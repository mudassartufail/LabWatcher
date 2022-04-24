using System;
using System.Collections;
using System.Collections.Generic;
using System.ComponentModel;
using System.Configuration.Install;
using System.Linq;
using System.ServiceProcess;
using System.Management;
using System.IO;
using System.Text;
using System.Net;


namespace LabWatcher
{
    [RunInstaller(true)]
    public partial class ProjectInstaller : System.Configuration.Install.Installer
    {
        public ProjectInstaller()
        {
            InitializeComponent();
        }


        void ComputerInfo()
        {
            string systemname = "";
            string processor = "";
            string ram = "";
            string harddisk="";
            const long OneKb = 1024;
            const long OneMb = OneKb * 1024;
            const long OneGb = OneMb * 1024;
            object ingb;

            //...........................................................
            ConnectionOptions opts = new ConnectionOptions();
            ManagementScope scope = new ManagementScope(@"\\.\root\cimv2", opts);
            string query = "select * from Win32_OperatingSystem";
            ObjectQuery oQuery = new ObjectQuery(query);
            ManagementObjectSearcher searcher = new ManagementObjectSearcher(scope, oQuery);
            ManagementObjectCollection recordSet = searcher.Get();
            foreach (ManagementObject record in recordSet)
            {
                systemname = "" + record.Properties["CSName"].Value;
            }
            //...........................................................
            

            //...........................................................
            Int64 diskUsage = 0;
            var moCollection = new ManagementClass("Win32_LogicalDisk").GetInstances();

            foreach (var mo in moCollection)
            {
                if (mo["DeviceID"] != null && mo["DriveType"] != null && mo["Size"] != null && mo["FreeSpace"] != null)
                {
                    // DriveType 3 = "Local Disk"
                    if (Convert.ToInt32(mo["DriveType"]) == 3)
                    {
                        diskUsage += Convert.ToInt64(mo["Size"]);
                    }
                }
            }

            ingb = Convert.ToInt64(diskUsage) / OneGb;
            harddisk = ingb.ToString();
            //...........................................................


            //...........................................................
            double totalsize = 0;
            query = "select * from Win32_PhysicalMemory";
            oQuery = new ObjectQuery(query);
            searcher = new ManagementObjectSearcher(scope, oQuery);
            recordSet = searcher.Get();

            foreach (ManagementObject record in recordSet)
            {
                totalsize += System.Convert.ToDouble(record.GetPropertyValue("Capacity"));
            }

            ingb = Convert.ToInt64(totalsize) / OneGb;
            ram = ingb.ToString();
            //...........................................................



            //...........................................................
            string sCpuInfo = String.Empty;
            //*** Declare Management Class
            ManagementClass clsMgtClass = new ManagementClass("Win32_Processor");
            ManagementObjectCollection colMgtObjCol = clsMgtClass.GetInstances();

            //*** Loop Over Objects
            foreach (ManagementObject objMgtObj in colMgtObjCol)
            {
                //*** Only return cpuInfo from first CPU
                if (sCpuInfo == String.Empty)
                {
                    sCpuInfo = objMgtObj.Properties["Name"].Value.ToString();
                }
            }
            processor = sCpuInfo;
            //...........................................................



            //...........................................................
            string oSInfo = String.Empty;
            //*** Declare Management Class
            clsMgtClass = new ManagementClass("Win32_OperatingSystem");
            colMgtObjCol = clsMgtClass.GetInstances();

            //*** Loop Over Objects
            foreach (ManagementObject objMgtObj in colMgtObjCol)
            {
                //*** Only return cpuInfo from first CPU
                if (oSInfo == String.Empty)
                {
                    oSInfo=Convert.ToString(objMgtObj.Properties["Caption"].Value);
                }
            }
            //...........................................................


            string openString = systemname + "$" + processor + "$" + ram + "$" + harddisk + "$" + oSInfo;

            //...............................................Repoting..................................................
            string host = "192.168.0.20";
            string url = "http://"+host+"/labwatcher/includes/ajax/pcregistration.php";
            string str = openString;
            HttpWebRequest req = (HttpWebRequest)WebRequest.Create(url);
            req.Method = "POST";
            string Data = "message=" + str;
            byte[] postBytes = Encoding.ASCII.GetBytes(Data);
            req.ContentType = "application/x-www-form-urlencoded";
            req.ContentLength = postBytes.Length;
            Stream requestStream = req.GetRequestStream();
            requestStream.Write(postBytes, 0, postBytes.Length);
            requestStream.Close();
            //.........................................................................................................
        }
        

        private void serviceInstaller1_AfterInstall(object sender, InstallEventArgs e)
        {
            ComputerInfo();
            new ServiceController(serviceInstaller1.ServiceName).Start();
        }

        private void ProjectInstaller_AfterUninstall(object sender, InstallEventArgs e)
        {
            string systemname = "";
            //...........................................................
            ConnectionOptions opts = new ConnectionOptions();
            ManagementScope scope = new ManagementScope(@"\\.\root\cimv2", opts);
            string query = "select * from Win32_OperatingSystem";
            ObjectQuery oQuery = new ObjectQuery(query);
            ManagementObjectSearcher searcher = new ManagementObjectSearcher(scope, oQuery);
            ManagementObjectCollection recordSet = searcher.Get();
            foreach (ManagementObject record in recordSet)
            {
                systemname = "" + record.Properties["CSName"].Value;
            }
            //...........................................................

            //...............................................Repoting..................................................
            string host = "192.168.0.20";
            string url = "http://"+host+"/labwatcher/includes/ajax/pcregistration.php";
            string str = systemname;
            HttpWebRequest req = (HttpWebRequest)WebRequest.Create(url);
            req.Method = "POST";
            string Data = "uninstall=" + str;
            byte[] postBytes = Encoding.ASCII.GetBytes(Data);
            req.ContentType = "application/x-www-form-urlencoded";
            req.ContentLength = postBytes.Length;
            Stream requestStream = req.GetRequestStream();
            requestStream.Write(postBytes, 0, postBytes.Length);
            requestStream.Close();
            //.........................................................................................................
        }


    }
}
