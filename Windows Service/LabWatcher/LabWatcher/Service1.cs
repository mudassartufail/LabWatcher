using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Diagnostics;
using System.Linq;
using System.ServiceProcess;
using System.Text;
using System.IO;
using System.Collections;
using System.Net;
using System.Management;
using System.Timers;
using System.Threading;

namespace LabWatcher
{
    public partial class Service1 : ServiceBase
    {

        static string systemName = "";
        static string host = "192.168.0.20";
        static System.Timers.Timer timer1 = new System.Timers.Timer();
        static System.Timers.Timer timer2 = new System.Timers.Timer();
        static Hashtable CofigErrorCodes;
        static Hashtable AvailErrorCodes;
        public static Thread thread1;
        public static Thread thread2;
        public static Thread thread3;

        public Service1()
        {
            InitializeComponent();
        }


        public static void ErrorDefinitions()
        {
            //CofigErrorCodes.Add("0", "Device is working properly.");
            CofigErrorCodes.Add("1", "Device is not configured correctly.");
            CofigErrorCodes.Add("2", "Windows cannot load the driver for this device.");
            CofigErrorCodes.Add("3", "Driver for this device might be corrupted, or the system may be low on memory or other resources.");
            CofigErrorCodes.Add("4", "Device is not working properly. One of its drivers or the registry might be corrupted.");
            CofigErrorCodes.Add("5", "Driver for the device requires a resource that Windows cannot manage.");
            CofigErrorCodes.Add("6", "Boot configuration for the device conflicts with other devices.");
            CofigErrorCodes.Add("8", "Driver loader for the device is missing.");
            CofigErrorCodes.Add("9", "Device is not working properly. The controlling firmware is incorrectly reporting the resources for the device.");
            CofigErrorCodes.Add("10", "Device cannot start.");
            CofigErrorCodes.Add("11", "Device failed.");
            CofigErrorCodes.Add("12", "Device cannot find enough free resources to use.");
            CofigErrorCodes.Add("13", "Windows cannot verify the device's resources.");
            CofigErrorCodes.Add("14", "Device cannot work properly until the computer is restarted.");
            CofigErrorCodes.Add("15", "Device is not working properly due to a possible re-enumeration problem.");
            CofigErrorCodes.Add("16", "Windows cannot identify all of the resources that the device uses.");
            CofigErrorCodes.Add("17", "Device is requesting an unknown resource type.");
            CofigErrorCodes.Add("18", "Device drivers must be reinstalled.");
            CofigErrorCodes.Add("19", "Failure using the VxD loader.");
            CofigErrorCodes.Add("20", "Registry might be corrupted.");
            CofigErrorCodes.Add("21", "System failure. If changing the device driver is ineffective, see the hardware documentation. Windows is removing the device.");
            CofigErrorCodes.Add("22", "Device is disabled.");
            CofigErrorCodes.Add("23", "System failure. If changing the device driver is ineffective, see the hardware documentation.");
            CofigErrorCodes.Add("24", "Device is not present, not working properly, or does not have all of its drivers installed.");
            CofigErrorCodes.Add("25", "Windows is still setting up the device.");
            CofigErrorCodes.Add("28", "Device drivers are not installed.");
            CofigErrorCodes.Add("29", "Device is disabled. The device firmware did not provide the required resources.");
            CofigErrorCodes.Add("30", "Device is using an IRQ resource that another device is using.");
            CofigErrorCodes.Add("31", "Device is not working properly. Windows cannot load the required device drivers.");


            AvailErrorCodes.Add("2", "Unknown");
            //AvailErrorCodes.Add("3", "Running");
            AvailErrorCodes.Add("4", "Warning");
            AvailErrorCodes.Add("7", "Power Off");
            AvailErrorCodes.Add("8", "Off Line");
            AvailErrorCodes.Add("9", "Off Duty");
            AvailErrorCodes.Add("10", "Not Installed");
            AvailErrorCodes.Add("11", "Install Error");
            AvailErrorCodes.Add("13", "Power Save - Unknown The device is known to be in a power save mode, but its exact status is unknown.");
            AvailErrorCodes.Add("14", "Power Save - Low Power Mode The device is in a power save state but still functioning, and may exhibit degraded performance.");
            AvailErrorCodes.Add("15", "Power Save - Standby The device is not functioning, but could be brought to full power quickly.");
            AvailErrorCodes.Add("16", "Power Cycle");
            AvailErrorCodes.Add("17", "Power Save - Warning The device is in a warning state, though also in a power save mode.");

        }

        public static void SystemName()
        {
            ConnectionOptions opts = new ConnectionOptions();
            ManagementScope scope = new ManagementScope(@"\\.\root\cimv2", opts);
            string query = "select * from Win32_OperatingSystem";
            ObjectQuery oQuery = new ObjectQuery(query);
            ManagementObjectSearcher searcher = new ManagementObjectSearcher(scope, oQuery);
            ManagementObjectCollection recordSet = searcher.Get();
            foreach (ManagementObject record in recordSet)
            {
                systemName = Convert.ToString(record.Properties["CSName"].Value);
            }
        }


        public static void ReportingSoftware(string openString)
        {
            //host = "192.168.0.20";
            //...............................................Repoting..................................................
            string url = "http://"+host+"/labwatcher/includes/ajax/softwarenotify.php";
            string str = openString;
            HttpWebRequest req = (HttpWebRequest)WebRequest.Create(url);
            req.Method = "POST";
            string Data = "softerror=" + str;
            byte[] postBytes = Encoding.ASCII.GetBytes(Data);
            req.ContentType = "application/x-www-form-urlencoded";
            req.ContentLength = postBytes.Length;
            Stream requestStream = req.GetRequestStream();
            requestStream.Write(postBytes, 0, postBytes.Length);
            requestStream.Close();
            //.........................................................................................................
        }


        //............................Start of Service.................................................................
        protected override void OnStart(string[] args)
        {
            //host = "192.168.0.20";
            SystemName();
            CofigErrorCodes = new Hashtable();
            AvailErrorCodes = new Hashtable();
            ErrorDefinitions();

            //............................. Device Status Section .......................................//
            string keyboardStatus = "";
            ConnectionOptions opts = new ConnectionOptions();
            ManagementScope scope = new ManagementScope(@"\\.\root\cimv2", opts);
            string query = "select * from Win32_Keyboard";
            ObjectQuery oQuery = new ObjectQuery(query);
            ManagementObjectSearcher searcher = new ManagementObjectSearcher(scope, oQuery);
            ManagementObjectCollection recordSet = searcher.Get();

            foreach (ManagementObject record in recordSet)
            {
                keyboardStatus = Convert.ToString(record.Properties["Status"].Value);
            }

            string mouseStatus = "";
            query = "select * from Win32_pointingdevice";
            oQuery = new ObjectQuery(query);
            searcher = new ManagementObjectSearcher(scope, oQuery);
            recordSet = searcher.Get();

            foreach (ManagementObject record in recordSet)
            {
                mouseStatus = Convert.ToString(record.Properties["Status"].Value);
            }

            string monitorStatus = "";
            query = "select * from Win32_DesktopMonitor";
            oQuery = new ObjectQuery(query);
            searcher = new ManagementObjectSearcher(scope, oQuery);
            recordSet = searcher.Get();

            foreach (ManagementObject record in recordSet)
            {
                monitorStatus = Convert.ToString(record.Properties["Status"].Value);
            }

            string processorStatus = "";
            query = "select * from Win32_Processor";
            oQuery = new ObjectQuery(query);
            searcher = new ManagementObjectSearcher(scope, oQuery);
            recordSet = searcher.Get();

            foreach (ManagementObject record in recordSet)
            {
                processorStatus = Convert.ToString(record.Properties["Status"].Value);
            }

            string diskStatus="";
            query = "select * from Win32_DiskDrive";
            oQuery = new ObjectQuery(query);
            searcher = new ManagementObjectSearcher(scope, oQuery);
            recordSet = searcher.Get();

            foreach (ManagementObject record in recordSet)
            {
                diskStatus = Convert.ToString(record.Properties["Status"].Value);
            }

            UInt32 ramCode = 100;
            object ramStatus = "";
            query = "select * from Win32_MemoryDevice";
            oQuery = new ObjectQuery(query);
            searcher = new ManagementObjectSearcher(scope, oQuery);
            recordSet = searcher.Get();

            foreach (ManagementObject record in recordSet)
            {
                ramCode = Convert.ToUInt32(record.Properties["ConfigManagerErrorCode"].Value);
            }

            if (CofigErrorCodes.Contains(ramCode.ToString()))
            {
                ramStatus = CofigErrorCodes[ramCode.ToString()];
            }
            else if (ramCode == 0)
            {
                ramStatus = "Device is working properly.";
            }

            object diskUsage = "";
            var moCollection = new ManagementClass("Win32_LogicalDisk").GetInstances();

            foreach (var mo in moCollection)
            {
                if (mo["DeviceID"] != null && mo["DriveType"] != null && mo["Size"] != null && mo["FreeSpace"] != null)
                {
                    // DriveType 3 = "Local Disk"
                    if (Convert.ToInt32(mo["DriveType"]) == 3)
                    {
                        diskUsage += mo["DeviceID"] + " " + mo["Size"] + " " + mo["FreeSpace"] + "|";
                    }
                }
            }

            string temp = systemName +"$" + keyboardStatus+"$"+mouseStatus+"$"+monitorStatus+"$"+processorStatus+"$"+diskStatus+"$"+ramStatus+"$"+diskUsage+"$"+'1';
            string deviceUrl = "http://"+host+"/labwatcher/includes/ajax/deviceStatus.php";
            HttpWebRequest reqDevice = (HttpWebRequest)WebRequest.Create(deviceUrl);
            reqDevice.Method = "POST";
            string deviceData = "status=" + temp;
            byte[] postDeviceBytes = Encoding.ASCII.GetBytes(deviceData);
            reqDevice.ContentType = "application/x-www-form-urlencoded";
            reqDevice.ContentLength = postDeviceBytes.Length;
            Stream requestDeviceStream = reqDevice.GetRequestStream();
            requestDeviceStream.Write(postDeviceBytes, 0, postDeviceBytes.Length);
            requestDeviceStream.Close();
            //..........................................................................................//

            ThreadStart hardThread = new ThreadStart(hardwareMonitor);
            thread1 = new Thread(hardThread);
            thread1.Start();

            ThreadStart softThread = new ThreadStart(softwareMonitor);
            thread2 = new Thread(softThread);
            thread2.Start();

            ThreadStart customThread = new ThreadStart(customMonitor);
            thread3 = new Thread(customThread);
            thread3.Start();
            
        }
        //............................End of Service...................................................................




        //..........................Custom Error Monitoring............................................................

        private static void customMonitor()
        {
            timer2.Elapsed += new ElapsedEventHandler(customChecker);
            timer2.Interval = 60000; // after every one minute
            timer2.Start();
        }

        private static void customChecker(object obj, EventArgs e)
        {
            string openString = "";

            //...................Free Physical Ram.........................//
            UInt64 freeRam=0;
            Int64 inMb=0;
            ManagementClass clsMgtClass = new ManagementClass("Win32_OperatingSystem");
            ManagementObjectCollection colMgtObjCol = clsMgtClass.GetInstances();

            //*** Loop Over Objects
            foreach (ManagementObject objMgtObj in colMgtObjCol)
            {
                freeRam = Convert.ToUInt64(objMgtObj.Properties["FreePhysicalMemory"].Value);
            }
            inMb = Convert.ToInt64(freeRam) / 1024;

            if (inMb < 200)
            {
                openString = systemName + " $ "+" | ";
                openString += "Warning | Low Physical Memory it may cause system to be Slow";
                ReportingSoftware(openString);
            }
            else if (inMb < 100)
            {
                openString = systemName + " $ "+" | ";
                openString += "Error | Extremely Low Physical Memory it may cause system to be Extremely Slow, performance may degrade";
                ReportingSoftware(openString);
            }
            //.................................................................//



            //...................Free Virtual Memory .........................//
            UInt64 freeVirtual=0;
            clsMgtClass = new ManagementClass("Win32_OperatingSystem");
            colMgtObjCol = clsMgtClass.GetInstances();

            //*** Loop Over Objects
            foreach (ManagementObject objMgtObj in colMgtObjCol)
            {
                freeVirtual = Convert.ToUInt64(objMgtObj.Properties["FreeVirtualMemory"].Value);
            }
            inMb = Convert.ToInt64(freeVirtual) / 1024;

            if (inMb < 200)
            {
                openString = systemName + " $ "+" | ";
                openString += "Warning | Low Virtual Memory it may cause system to be slow";
                ReportingSoftware(openString);
            }
            else if (inMb < 100)
            {
                openString = systemName + " $ "+" | ";
                openString += "Error | Extremely Low Virtual Memory it may cause system to be Extremely Slow, performance may degrade";
                ReportingSoftware(openString);
            }
            //..............................................................//



            //...................Processes Counter .........................//
            UInt64 process=0;
            UInt64 maxprocess=0;
            clsMgtClass = new ManagementClass("Win32_OperatingSystem");
            colMgtObjCol = clsMgtClass.GetInstances();

            //*** Loop Over Objects
            foreach (ManagementObject objMgtObj in colMgtObjCol)
            {
                process = Convert.ToUInt64(objMgtObj.Properties["NumberOfProcesses"].Value);
                maxprocess = Convert.ToUInt64(objMgtObj.Properties["MaxNumberOfProcesses"].Value);
            }

            if (process > maxprocess - 200)
            {
                openString = systemName + " $ "+" | ";
                openString += "Warning | Too many processes are running it may cause system to be slow";
                ReportingSoftware(openString);
            }
            else if (process > maxprocess - 100)
            {
                openString = systemName + " $ "+" | ";
                openString += "Error | Too many processes are running it may cause system to be slow, performance may degrade";
                ReportingSoftware(openString);
            }
            //.............................................................//



            //...................Hard Disk Storage .........................//
            ManagementObject disk = new ManagementObject("win32_logicaldisk.deviceid=\"c:\"");
            disk.Get();
            Int64 temp = Convert.ToInt64(disk["FreeSpace"]);
            Int64 space = temp / (1024 * 1024);

            if (space < 200)
            {
                openString = systemName + " $ "+" | ";
                openString += "Warning | Too short free space in Drive C:\\ which may cause system to be slow";
                ReportingSoftware(openString);
            }
            else if (space < 100)
            {
                openString = systemName + " $ "+" | ";
                openString += "Error | Extremly short free space in Drive C:\\ which may cause system to be slow, performance may degrade";
                ReportingSoftware(openString);
            }
            //.............................................................//

            //Thread.Sleep(3);
        }
        //.............................End of Custom Monitor...........................................................



        //....................Hardware Error Checking..................................................................

        private static void hardwareMonitor()
        {
            timer1.Elapsed += new ElapsedEventHandler(checker);
            timer1.Interval = 600000; // every 10 minute
            timer1.Start();
        }

        private static void softwareMonitor()
        {
            var appEventLog = new EventLog("Application");  // Windows Application Logs
            var systemLog = new EventLog("System"); //Windows System Logs
            appEventLog.EntryWritten += new EntryWrittenEventHandler(appEntryEvent); //Event for Application Log
            appEventLog.EnableRaisingEvents = true;
            systemLog.EntryWritten += new EntryWrittenEventHandler(systemEntryEvent); //Event for System Log
            systemLog.EnableRaisingEvents = true;   
        }


        private static void checker(object obj, EventArgs e)
        {
            //host = "192.168.0.20";

            string status = "";
            UInt16 availability=0;
            UInt32 configerrorcode=0;

            ConnectionOptions opts = new ConnectionOptions();
            ManagementScope scope = new ManagementScope(@"\\.\root\cimv2", opts);
            string query = "select * from Win32_Keyboard";
            ObjectQuery oQuery = new ObjectQuery(query);
            ManagementObjectSearcher searcher = new ManagementObjectSearcher(scope, oQuery);
            ManagementObjectCollection recordSet = searcher.Get();

            foreach (ManagementObject record in recordSet)
            {
                status = Convert.ToString(record.Properties["Status"].Value);
                availability = Convert.ToUInt16(record.Properties["Availability"].Value);
                configerrorcode = Convert.ToUInt32(record.Properties["ConfigManagerErrorCode"].Value);
            }

            if (AvailErrorCodes.Contains(availability.ToString()))
            {
                string errorMessage = "Keyboard | ";
                errorMessage+=AvailErrorCodes[availability.ToString()];
                //...............................................Repoting..................................................
                string url = "http://" + host + "/labwatcher/includes/ajax/hardwarenotify.php";
                string str = errorMessage;
                str += "$" + systemName;
                HttpWebRequest req = (HttpWebRequest)WebRequest.Create(url);
                req.Method = "POST";
                string Data = "harderror=" + str;
                byte[] postBytes = Encoding.ASCII.GetBytes(Data);
                req.ContentType = "application/x-www-form-urlencoded";
                req.ContentLength = postBytes.Length;
                Stream requestStream = req.GetRequestStream();
                requestStream.Write(postBytes, 0, postBytes.Length);
                requestStream.Close();
                //.........................................................................................................
            }

            if (CofigErrorCodes.Contains(configerrorcode.ToString()))
            {
                string errorMessage = "Keyboard | ";
                errorMessage+= CofigErrorCodes[configerrorcode.ToString()];
                //...............................................Repoting..................................................
                string url = "http://" + host + "/labwatcher/includes/ajax/hardwarenotify.php";
                string str = errorMessage;
                str += "$" + systemName;
                HttpWebRequest req = (HttpWebRequest)WebRequest.Create(url);
                req.Method = "POST";
                string Data = "harderror=" + str;
                byte[] postBytes = Encoding.ASCII.GetBytes(Data);
                req.ContentType = "application/x-www-form-urlencoded";
                req.ContentLength = postBytes.Length;
                Stream requestStream = req.GetRequestStream();
                requestStream.Write(postBytes, 0, postBytes.Length);
                requestStream.Close();
                //.........................................................................................................
            }

            if (status!="OK")
            {
                status="Keyboard | "+status;
                //...............................................Repoting..................................................
                string url = "http://" + host + "/labwatcher/includes/ajax/hardwarenotify.php";
                string str = status;
                str += "$" + systemName;
                HttpWebRequest req = (HttpWebRequest)WebRequest.Create(url);
                req.Method = "POST";
                string Data = "harderror=" + str;
                byte[] postBytes = Encoding.ASCII.GetBytes(Data);
                req.ContentType = "application/x-www-form-urlencoded";
                req.ContentLength = postBytes.Length;
                Stream requestStream = req.GetRequestStream();
                requestStream.Write(postBytes, 0, postBytes.Length);
                requestStream.Close();
                //.........................................................................................................
            }


            query = "select * from Win32_pointingdevice";
            oQuery = new ObjectQuery(query);
            searcher = new ManagementObjectSearcher(scope, oQuery);
            recordSet = searcher.Get();

            foreach (ManagementObject record in recordSet)
            {
                status = Convert.ToString(record.Properties["Status"].Value);
                availability = Convert.ToUInt16(record.Properties["Availability"].Value);
                configerrorcode = Convert.ToUInt32(record.Properties["ConfigManagerErrorCode"].Value);
            }


            if (AvailErrorCodes.Contains(availability.ToString()))
            {
                string errorMessage = "Mouse | ";
                errorMessage+= AvailErrorCodes[availability.ToString()];
                //...............................................Repoting..................................................
                string url = "http://" + host + "/labwatcher/includes/ajax/hardwarenotify.php";
                string str = errorMessage;
                str += "$" + systemName;
                HttpWebRequest req = (HttpWebRequest)WebRequest.Create(url);
                req.Method = "POST";
                string Data = "harderror=" + str;
                byte[] postBytes = Encoding.ASCII.GetBytes(Data);
                req.ContentType = "application/x-www-form-urlencoded";
                req.ContentLength = postBytes.Length;
                Stream requestStream = req.GetRequestStream();
                requestStream.Write(postBytes, 0, postBytes.Length);
                requestStream.Close();
                //.........................................................................................................
            }

            if (CofigErrorCodes.Contains(configerrorcode.ToString()))
            {
                string errorMessage = "Mouse | ";
                errorMessage+=CofigErrorCodes[configerrorcode.ToString()];
                //...............................................Repoting..................................................
                string url = "http://" + host + "/labwatcher/includes/ajax/hardwarenotify.php";
                string str = errorMessage;
                str += "$" + systemName;
                HttpWebRequest req = (HttpWebRequest)WebRequest.Create(url);
                req.Method = "POST";
                string Data = "harderror=" + str;
                byte[] postBytes = Encoding.ASCII.GetBytes(Data);
                req.ContentType = "application/x-www-form-urlencoded";
                req.ContentLength = postBytes.Length;
                Stream requestStream = req.GetRequestStream();
                requestStream.Write(postBytes, 0, postBytes.Length);
                requestStream.Close();
                //.........................................................................................................
            }

            if (status !="OK")
            {
                status="Mouse | "+status;
                //...............................................Repoting..................................................
                string url = "http://" + host + "/labwatcher/includes/ajax/hardwarenotify.php";
                string str = status;
                str += "$" + systemName;
                HttpWebRequest req = (HttpWebRequest)WebRequest.Create(url);
                req.Method = "POST";
                string Data = "harderror=" + str;
                byte[] postBytes = Encoding.ASCII.GetBytes(Data);
                req.ContentType = "application/x-www-form-urlencoded";
                req.ContentLength = postBytes.Length;
                Stream requestStream = req.GetRequestStream();
                requestStream.Write(postBytes, 0, postBytes.Length);
                requestStream.Close();
                //.........................................................................................................
            }


            query = "select * from Win32_DesktopMonitor";
            oQuery = new ObjectQuery(query);
            searcher = new ManagementObjectSearcher(scope, oQuery);
            recordSet = searcher.Get();

            foreach (ManagementObject record in recordSet)
            {
                status = Convert.ToString(record.Properties["Status"].Value);
                availability = Convert.ToUInt16(record.Properties["Availability"].Value);
                configerrorcode = Convert.ToUInt32(record.Properties["ConfigManagerErrorCode"].Value);
            }

            if (AvailErrorCodes.Contains(availability.ToString()))
            {
                string errorMessage = "Monitor | ";
                errorMessage+= AvailErrorCodes[availability.ToString()];
                //...............................................Repoting..................................................
                string url = "http://" + host + "/labwatcher/includes/ajax/hardwarenotify.php";
                string str = errorMessage;
                str += "$" + systemName;
                HttpWebRequest req = (HttpWebRequest)WebRequest.Create(url);
                req.Method = "POST";
                string Data = "harderror=" + str;
                byte[] postBytes = Encoding.ASCII.GetBytes(Data);
                req.ContentType = "application/x-www-form-urlencoded";
                req.ContentLength = postBytes.Length;
                Stream requestStream = req.GetRequestStream();
                requestStream.Write(postBytes, 0, postBytes.Length);
                requestStream.Close();
                //.........................................................................................................
            }

            if (CofigErrorCodes.Contains(configerrorcode.ToString()))
            {
                string errorMessage = "Monitor | ";
                errorMessage+=CofigErrorCodes[configerrorcode.ToString()];
                //...............................................Repoting..................................................
                string url = "http://" + host + "/labwatcher/includes/ajax/hardwarenotify.php";
                string str = errorMessage;
                str += "$" + systemName;
                HttpWebRequest req = (HttpWebRequest)WebRequest.Create(url);
                req.Method = "POST";
                string Data = "harderror=" + str;
                byte[] postBytes = Encoding.ASCII.GetBytes(Data);
                req.ContentType = "application/x-www-form-urlencoded";
                req.ContentLength = postBytes.Length;
                Stream requestStream = req.GetRequestStream();
                requestStream.Write(postBytes, 0, postBytes.Length);
                requestStream.Close();
                //.........................................................................................................
            }

            if (status != "OK")
            {
                status="Monitor | "+status;
                //...............................................Repoting..................................................
                string url = "http://" + host + "/labwatcher/includes/ajax/hardwarenotify.php";
                string str = status;
                str += "$" + systemName;
                HttpWebRequest req = (HttpWebRequest)WebRequest.Create(url);
                req.Method = "POST";
                string Data = "harderror=" + str;
                byte[] postBytes = Encoding.ASCII.GetBytes(Data);
                req.ContentType = "application/x-www-form-urlencoded";
                req.ContentLength = postBytes.Length;
                Stream requestStream = req.GetRequestStream();
                requestStream.Write(postBytes, 0, postBytes.Length);
                requestStream.Close();
                //.........................................................................................................
            }

            query = "select * from Win32_DiskDrive";
            oQuery = new ObjectQuery(query);
            searcher = new ManagementObjectSearcher(scope, oQuery);
            recordSet = searcher.Get();

            foreach (ManagementObject record in recordSet)
            {
                status = Convert.ToString(record.Properties["Status"].Value);
                availability = Convert.ToUInt16(record.Properties["Availability"].Value);
                configerrorcode = Convert.ToUInt32(record.Properties["ConfigManagerErrorCode"].Value);
            }

            if (AvailErrorCodes.Contains(availability.ToString()))
            {
                string errorMessage = "Hard Disk | ";
                errorMessage+= AvailErrorCodes[availability.ToString()];
                //...............................................Repoting..................................................
                string url = "http://" + host + "/labwatcher/includes/ajax/hardwarenotify.php";
                string str = errorMessage;
                str += "$" + systemName;
                HttpWebRequest req = (HttpWebRequest)WebRequest.Create(url);
                req.Method = "POST";
                string Data = "harderror=" + str;
                byte[] postBytes = Encoding.ASCII.GetBytes(Data);
                req.ContentType = "application/x-www-form-urlencoded";
                req.ContentLength = postBytes.Length;
                Stream requestStream = req.GetRequestStream();
                requestStream.Write(postBytes, 0, postBytes.Length);
                requestStream.Close();
                //.........................................................................................................
            }

            if (CofigErrorCodes.Contains(configerrorcode.ToString()))
            {
                string errorMessage = "Hard Disk | ";
                errorMessage+=CofigErrorCodes[configerrorcode.ToString()];
                //...............................................Repoting..................................................
                string url = "http://" + host + "/labwatcher/includes/ajax/hardwarenotify.php";
                string str = errorMessage;
                str += "$" + systemName;
                HttpWebRequest req = (HttpWebRequest)WebRequest.Create(url);
                req.Method = "POST";
                string Data = "harderror=" + str;
                byte[] postBytes = Encoding.ASCII.GetBytes(Data);
                req.ContentType = "application/x-www-form-urlencoded";
                req.ContentLength = postBytes.Length;
                Stream requestStream = req.GetRequestStream();
                requestStream.Write(postBytes, 0, postBytes.Length);
                requestStream.Close();
                //.........................................................................................................
            }

            if (status != "OK")
            {
                status="Hard Disk | "+status;
                //...............................................Repoting..................................................
                string url = "http://" + host + "/labwatcher/includes/ajax/hardwarenotify.php";
                string str = status;
                str += "$" + systemName;
                HttpWebRequest req = (HttpWebRequest)WebRequest.Create(url);
                req.Method = "POST";
                string Data = "harderror=" + str;
                byte[] postBytes = Encoding.ASCII.GetBytes(Data);
                req.ContentType = "application/x-www-form-urlencoded";
                req.ContentLength = postBytes.Length;
                Stream requestStream = req.GetRequestStream();
                requestStream.Write(postBytes, 0, postBytes.Length);
                requestStream.Close();
                //.........................................................................................................
            }


            query = "select * from Win32_Processor";
            oQuery = new ObjectQuery(query);
            searcher = new ManagementObjectSearcher(scope, oQuery);
            recordSet = searcher.Get();

            foreach (ManagementObject record in recordSet)
            {
                status = Convert.ToString(record.Properties["Status"].Value);
                availability = Convert.ToUInt16(record.Properties["Availability"].Value);
                configerrorcode = Convert.ToUInt32(record.Properties["ConfigManagerErrorCode"].Value);
            }

            if (AvailErrorCodes.Contains(availability.ToString()))
            {
                string errorMessage = "Processor | ";
                errorMessage+= AvailErrorCodes[availability.ToString()];
                //...............................................Repoting..................................................
                string url = "http://" + host + "/labwatcher/includes/ajax/hardwarenotify.php";
                string str = errorMessage;
                str += "$" + systemName;
                HttpWebRequest req = (HttpWebRequest)WebRequest.Create(url);
                req.Method = "POST";
                string Data = "harderror=" + str;
                byte[] postBytes = Encoding.ASCII.GetBytes(Data);
                req.ContentType = "application/x-www-form-urlencoded";
                req.ContentLength = postBytes.Length;
                Stream requestStream = req.GetRequestStream();
                requestStream.Write(postBytes, 0, postBytes.Length);
                requestStream.Close();
                //.........................................................................................................
            }

            if (CofigErrorCodes.Contains(configerrorcode.ToString()))
            {
                string errorMessage = "Processor | ";
                errorMessage+=CofigErrorCodes[configerrorcode.ToString()];
                //...............................................Repoting..................................................
                string url = "http://" + host + "/labwatcher/includes/ajax/hardwarenotify.php";
                string str = errorMessage;
                str += "$" + systemName;
                HttpWebRequest req = (HttpWebRequest)WebRequest.Create(url);
                req.Method = "POST";
                string Data = "harderror=" + str;
                byte[] postBytes = Encoding.ASCII.GetBytes(Data);
                req.ContentType = "application/x-www-form-urlencoded";
                req.ContentLength = postBytes.Length;
                Stream requestStream = req.GetRequestStream();
                requestStream.Write(postBytes, 0, postBytes.Length);
                requestStream.Close();
                //.........................................................................................................
            }

            if (status != "OK")
            {
                status="Processor | "+status;
                //...............................................Repoting..................................................
                string url = "http://" + host + "/labwatcher/includes/ajax/hardwarenotify.php";
                string str = status;
                str += "$" + systemName;
                HttpWebRequest req = (HttpWebRequest)WebRequest.Create(url);
                req.Method = "POST";
                string Data = "harderror=" + str;
                byte[] postBytes = Encoding.ASCII.GetBytes(Data);
                req.ContentType = "application/x-www-form-urlencoded";
                req.ContentLength = postBytes.Length;
                Stream requestStream = req.GetRequestStream();
                requestStream.Write(postBytes, 0, postBytes.Length);
                requestStream.Close();
                //.........................................................................................................
            }

            //Thread.Sleep(8);
        }

        //.............................................................................................................




        //................................Application Log Event........................................................
        public static void appEntryEvent(object sender, EntryWrittenEventArgs e)
        {
            if (e.Entry.EntryType == EventLogEntryType.Error || e.Entry.EntryType == EventLogEntryType.Warning)
            {
                string openString = "";
                openString = systemName + " $  "+" | ";
                openString += e.Entry.EntryType.ToString() + " | ";
                openString += e.Entry.Message;
                ReportingSoftware(openString);
            }
        }
        //................................End of Application Log Event.................................................




        //................................System Log Event.............................................................
        public static void systemEntryEvent(object sender, EntryWrittenEventArgs e)
        {
            if (e.Entry.EntryType == EventLogEntryType.Error || e.Entry.EntryType == EventLogEntryType.Warning)
            {
                string openString = "";
                openString = systemName + " $ " + " | ";
                openString += e.Entry.EntryType.ToString() + " | ";
                openString += e.Entry.Message;
                ReportingSoftware(openString);
            }
        }
        //................................End of System Log Event......................................................

        

        //............................Start of Service.................................................................
        protected override void OnStop()
        {
            //............................. Device Status Section .......................................//
            string keyboardStatus = "";
            ConnectionOptions opts = new ConnectionOptions();
            ManagementScope scope = new ManagementScope(@"\\.\root\cimv2", opts);
            string query = "select * from Win32_Keyboard";
            ObjectQuery oQuery = new ObjectQuery(query);
            ManagementObjectSearcher searcher = new ManagementObjectSearcher(scope, oQuery);
            ManagementObjectCollection recordSet = searcher.Get();

            foreach (ManagementObject record in recordSet)
            {
                keyboardStatus = Convert.ToString(record.Properties["Status"].Value);
            }

            string mouseStatus = "";
            query = "select * from Win32_pointingdevice";
            oQuery = new ObjectQuery(query);
            searcher = new ManagementObjectSearcher(scope, oQuery);
            recordSet = searcher.Get();

            foreach (ManagementObject record in recordSet)
            {
                mouseStatus = Convert.ToString(record.Properties["Status"].Value);
            }

            string monitorStatus = "";
            query = "select * from Win32_DesktopMonitor";
            oQuery = new ObjectQuery(query);
            searcher = new ManagementObjectSearcher(scope, oQuery);
            recordSet = searcher.Get();

            foreach (ManagementObject record in recordSet)
            {
                monitorStatus = Convert.ToString(record.Properties["Status"].Value);
            }

            string processorStatus = "";
            query = "select * from Win32_Processor";
            oQuery = new ObjectQuery(query);
            searcher = new ManagementObjectSearcher(scope, oQuery);
            recordSet = searcher.Get();

            foreach (ManagementObject record in recordSet)
            {
                processorStatus = Convert.ToString(record.Properties["Status"].Value);
            }

            string diskStatus = "";
            query = "select * from Win32_DiskDrive";
            oQuery = new ObjectQuery(query);
            searcher = new ManagementObjectSearcher(scope, oQuery);
            recordSet = searcher.Get();

            foreach (ManagementObject record in recordSet)
            {
                diskStatus = Convert.ToString(record.Properties["Status"].Value);
            }

            UInt32 ramCode=100;
            object ramStatus = "";
            query = "select * from Win32_MemoryDevice";
            oQuery = new ObjectQuery(query);
            searcher = new ManagementObjectSearcher(scope, oQuery);
            recordSet = searcher.Get();

            foreach (ManagementObject record in recordSet)
            {
                ramCode = Convert.ToUInt32(record.Properties["ConfigManagerErrorCode"].Value);
            }

            if (CofigErrorCodes.Contains(ramCode.ToString()))
            {
                ramStatus = CofigErrorCodes[ramCode.ToString()];
            }
            else if (ramCode==0)
            {
                ramStatus = "Device is working properly.";
            }

            object diskUsage = "";
            var moCollection = new ManagementClass("Win32_LogicalDisk").GetInstances();

            foreach (var mo in moCollection)
            {
                if (mo["DeviceID"] != null && mo["DriveType"] != null && mo["Size"] != null && mo["FreeSpace"] != null)
                {
                    // DriveType 3 = "Local Disk"
                    if (Convert.ToInt32(mo["DriveType"]) == 3)
                    {
                        diskUsage += mo["DeviceID"] + " " + mo["Size"] + " " + mo["FreeSpace"] + "|";
                    }
                }
            }

            string temp = systemName + "$" + keyboardStatus + "$" + mouseStatus + "$" + monitorStatus + "$" + processorStatus + "$" + diskStatus+"$"+ramStatus+"$"+diskUsage+"$"+'0';
            string deviceUrl = "http://" + host + "/labwatcher/includes/ajax/deviceStatus.php";
            HttpWebRequest reqDevice = (HttpWebRequest)WebRequest.Create(deviceUrl);
            reqDevice.Method = "POST";
            string deviceData = "status=" + temp;
            byte[] postDeviceBytes = Encoding.ASCII.GetBytes(deviceData);
            reqDevice.ContentType = "application/x-www-form-urlencoded";
            reqDevice.ContentLength = postDeviceBytes.Length;
            Stream requestDeviceStream = reqDevice.GetRequestStream();
            requestDeviceStream.Write(postDeviceBytes, 0, postDeviceBytes.Length);
            requestDeviceStream.Close();
            //..........................................................................................//

            timer1.Close();
            timer2.Close();
            
            thread3.Abort();
            thread1.Abort();
            thread2.Abort();
            
        }
        //............................End of Service...................................................................
    }
}
