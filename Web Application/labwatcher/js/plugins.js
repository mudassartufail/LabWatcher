$(document).ready(function(){

    // Bootstrap tooltip
    $(".tip").tooltip({placement: 'top', trigger: 'hover'});
    $(".tipb").tooltip({placement: 'bottom', trigger: 'hover'});
    $(".tipl").tooltip({placement: 'left', trigger: 'hover'});
    $(".tipr").tooltip({placement: 'right', trigger: 'hover'});

    // fullcalendar
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    var calendar = $('#main_calendar').fullCalendar({
            header: {		
                    left: 'prev,next',
                    center: 'title',
                    right: '',
                    right: 'month,agendaWeek,agendaDay'
            },   
            selectable: true,
            selectHelper: true,
            select: function(start, end) {
                                        
                    $('#fcAddEvent').modal('show');
                    
                    $("#fcAddEventButton").click(function(){
                        
                        var title = $("#fcAddEventTitle").val();
                        
                        if(title){
                            calendar.fullCalendar('renderEvent',
                                        {
                                                title: title,
                                                start: start,
                                                end: end
                                        },true
                                );
                                notify('Fullcalendar','New Event: '+title+';<br/>start: '+start+';<br/>end: '+end+';');
                        }
                        
                        $('#fcAddEvent').modal('hide'); 
                        $("#fcAddEventTitle").val('');
                        calendar.fullCalendar('unselect');
                    });                    
            },
            editable: true,
            eventDrop: function(event, delta) {               
                notify('Fullcalendar','Event: '+event.title+' = '+delta);
            },
            events: {
                url: "php/ajax_fullcalendar.php",
                success: function(){
                    notify('Fullcalendar','Success ajax load');
                }
            }
    });    
        
    
    // Pnotify notifier
        $.pnotify.defaults.history = false;
        $.pnotify.defaults.delay = 3000;        
                       
    // Fancybox for images
        $("a.fb").fancybox({padding: 10,
                            'transitionIn'  : 'elastic',
                            'transitionOut' : 'elastic',
                            'speedIn'       : 600, 
                            'speedOut'      : 200
                        });
		// Fancy box for html pages
        $("a.iframe").fancybox({padding: 10,
                            'transitionIn'  : 'elastic',
                            'transitionOut' : 'elastic',
							'type' 			: 'iframe',
                        });
    // Uniform
        //$("input:checkbox, input:radio").not('input.iButton').uniform();
    
    // Select2
        $(".select").select2();
        /*$(".select").on("change", function(e) {             
            notify('Select','Value changed: '+e.val);
        });*/
        
    // Tagsinput
        $(".tags").tagsInput({'width':'100%',
                              'height':'auto',
                              'onAddTag': function(text){
                                notify('Tags input','Added tag: '+text);
                              },
                              'onRemoveTag': function(text){
                                notify('Tags input','Removed tag: '+text);  
                              }});
        
    // Masked input        
        $("input.mask_tin").mask('99-9999999',{completed:function(){
                                                notify('Masked input','mask_tin completed');                                                
                                              }});
        $("input.mask_ssn").mask('999-99-9999',{completed:function(){
                                                notify('Masked input','mask_ssn completed');                                                
                                              }});        
        $("input.mask_date").mask('9999-99-99',{completed:function(){
                                                notify('Masked input','mask_date completed');
                                              }});
        $("input.mask_product").mask('a*-999-a999',{completed:function(){
                                                notify('Masked input','mask_product completed');
                                              }});
        $("input.mask_phone").mask('99 (999) 999-99-99',{completed:function(){
                                                notify('Masked input','mask_phone completed');
                                              }});
        $("input.mask_phone_ext").mask('99 (999) 999-9999? x99999',{completed:function(){
                                                notify('Masked input','mask_phone_ext completed');
                                              }});
        $("input.mask_credit").mask('9999-9999-9999-9999',{completed:function(){
                                                notify('Masked input','mask_credit completed');
                                              }});        
        $("input.mask_percent").mask('99%',{completed:function(){
                                                //notify('Masked input','mask_percent completed');
                                              }});       
        $("input.mask_tax_ratio").mask('99',{completed:function(){
                                                //notify('Masked input','mask_percent completed');
                                              }});
    
    // Multiselect    
    if($("#ms").length > 0)
        $("#ms").multiSelect({
            afterSelect: function(value, text){
                //notify('Multiselect','Selected: '+text+'['+value+']');
            },
            afterDeselect: function(value, text){
                //notify('Multiselect','Deselected: '+text+'['+value+']');
            }});
    
    
    if($("#msc").length > 0 || $("#compliance").length > 0){
        $("#msc").multiSelect({
            selectableHeader: "<div class='multipleselect-header'>All PP Rules</div>",
            selectedHeader: "<div class='multipleselect-header'>Violated PP Rules</div>",
            afterSelect: function(value, text){
               // notify('Multiselect','Selected: '+text+'['+value+']');
            },
            afterDeselect: function(value, text){
                //notify('Multiselect','Deselected: '+text+'['+value+']');
            }            
        });
		
		$("#compliance").multiSelect({
            selectableHeader: "<div class='multipleselect-header'>Violated PP Rules</div>",
            selectedHeader: "<div class='multipleselect-header'>Compliance Received For PP Rules</div>",
            afterSelect: function(value, text){
               // notify('Multiselect','Selected: '+text+'['+value+']');
            },
            afterDeselect: function(value, text){
                //notify('Multiselect','Deselected: '+text+'['+value+']');
            }            
        });
        
        $("#ms_select").click(function(){
            $('#msc, #compliance').multiSelect('select_all');
        });
        $("#ms_deselect").click(function(){
            $('#msc, #compliance').multiSelect('deselect_all');
        });        
    }
    
    
    // Breadcrumb
    $(".breadCrumb").jBreadCrumb({easing:'swing'});
    
    // Validation
    if($("#validate").length > 0)
        $("#validate, #validate_custom").validationEngine('attach',{promptPosition : "topLeft"});
    
    // Datepicker
    $(".datepicker").datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange: 'c-5:c+5',
		maxDate: 'w'
	});
    
    if($("#datepicker").length > 0){
        
        $( "#datepicker" ).datepicker({dateFormat: 'yy-mm-dd',
                                       onSelect: function(date){
                                            notify('Datepicker', 'Date: '+date)
                                     }});
    }
        
    
    // Wizard
    if($("#wizard").length > 0) $('#wizard').stepy();
    
    if($("#wizard_validate").length > 0){
        
        $("#wizard_validate").validationEngine('attach',{promptPosition : "topLeft"});
        
        $('#wizard_validate').stepy({
            back: function(index) {                                                                
                //if(!$("#wizard_validate").validationEngine('validate')) return false; //uncomment if u need to validate on back click                
            }, 
            next: function(index) {                
                if(!$("#wizard_validate").validationEngine('validate')) return false;                
            }, 
            finish: function(index) {                
                if(!$("#wizard_validate").validationEngine('validate')) return false;
            }            
        });
    }

    if($("#wizard_ajax").length > 0){
        
        $("#wizard_ajax").validationEngine('attach',{promptPosition : "topLeft"});
        
        $('#wizard_ajax').stepy({
            back: function(index) {                
                return false;
            }, 
            next: function(index) {                
                if(!$("#wizard_ajax").validationEngine('validate')) return false;
                
                
                
                if((index-2) == 0){
                    $.post('php/ajax_wizard.php',{login: $("#wizard_ajax input[name=login]").val(),
                                                email: $("#wizard_ajax input[name=email]").val()},
                                                function(data){
                                                        if(data == 'success')
                                                            $('#wizard_ajax').stepy('step', index);
                                                        else
                                                            $('#wizard_ajax input[name=login]').validationEngine('showPrompt', 'Response doesn\'t match', 'error','topLeft', true);
                                                });                    
                    return false;
                }                                                
                                
                if((index-2) == 1){
                    $.post('php/ajax_wizard.php',{hash: $("#wizard_ajax input[name=hash]").val()},
                                                  function(data){
                                                    if(data == 'success')
                                                        $('#wizard_ajax').stepy('step', index);
                                                    else
                                                        $('#wizard_ajax input[name=hash]').validationEngine('showPrompt', 'Response doesn\'t match', 'error','topLeft', true);
                                                  });                                
                    return false;
                }

            },
            finish: function(index) {                
                if(!$("#wizard_ajax").validationEngine('validate')) return false;
                
                notify('Wizard','Form #wizard_ajax submited with:<br/>'+$("#wizard_ajax").serialize());
            }            
        });
    }

    // eof wizard
    
    // accordion
    $(".accordion").accordion({heightStyle: "content", collapsible: true, active: false});
    // eof accordion
    
    // tabs
    $(".tabs").tabs();
    // eof tabs
    
    // progressbars
    if($("#progressbar_default").length > 0)
        $("#progressbar_default").progressbar({value: 65});
    
    if($("#progressbar_animated").length > 0){        
        $("#progressbar_animated").progressbar({value: 0});
        $("#sAProgress").click(function(){
            $("#progressbar_animated").progressbar('destroy');
            var iNow = new Date().setTime(new Date().getTime() + 0 * 1000);
            var iEnd = new Date().setTime(new Date().getTime() + 5 * 1000);
            $("#progressbar_animated").anim_progressbar({start: iNow, finish: iEnd, interval: 1});
        });
    }
    
    if($("#progressbar_delay").length > 0){        
        $("#progressbar_delay").progressbar({value: 0});
        $("#sWDProgress").click(function(){
            $("#progressbar_delay").progressbar('destroy');
            var iNow1 = new Date().setTime(new Date().getTime() + 3 * 1000);
            var iEnd1 = new Date().setTime(new Date().getTime() + 6 * 1000);
            $("#progressbar_delay").anim_progressbar({start: iNow1, finish: iEnd1, interval: 1});
        });
    }
    // eof progressbars
    
    // spinner
        $( "#spinner" ).spinner({min: 1, max: 100, step: 1, start: 1});
        $( "#spinner1" ).spinner({culture: "en-US", min: 5, max: 1000, step: 10, start: 10, numberFormat: "C"});
    // eof spinner
    
    // sliders
        $("#slider_1").slider({
            value: 60,
            orientation: "horizontal",
            range: "min",
            animate: true,
            slide: function( event, ui ) {
                $( "#slider_1_amount" ).html( "$" + ui.value );
            },
            stop: function( event, ui ) {
                notify('Slider','#slider_1: '+ui.value);
            }
        });
        
        $("#slider_2").slider({
            values: [ 17, 67 ],
            orientation: "horizontal",
            range: true,
            animate: true,
            slide: function( event, ui ) {
                $( "#slider_2_amount" ).html( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
            },
            stop: function( event, ui ) {
                notify('Slider','#slider_2: '+ui.values[0]+' - '+ui.values[ 1 ]);
            }            
        });    
            
        $("#slider_3").slider({
            orientation: "vertical",
            range: "min",
            min: 0,
            max: 100,
            value: 10,            
            stop: function( event, ui ) {
                notify('Slider','#slider_3: '+ui.value);
            }            
        }); 

        $("#slider_4").slider({
            orientation: "vertical",
            range: true,
            values: [ 17, 67 ],
            stop: function( event, ui ) {
                notify('Slider','#slider_4: '+ui.values[0]+' - '+ui.values[1]);
            }
        }); 

        $("#slider_5").slider({
            orientation: "vertical",            
            range: "max",
            min: 1,
            max: 10,
            value: 2,
            stop: function( event, ui ) {
                notify('Slider','#slider_5: '+ui.value);
            }            
        });     
    // eof sliders
    
    // popovers
    
    $("#popover_top").popover({placement: 'top', title: 'Popover title', content: 'Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor velit.'});
    $("#popover_right").popover({placement: 'right', title: 'Popover title', content: 'Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor velit.'});
    $("#popover_bottom").popover({placement: 'bottom', title: 'Popover title', content: 'Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor velit.'});
    $("#popover_left").popover({placement: 'left', title: 'Popover title', content: 'Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor velit.'});
    
    // eof popovers
    
    // jQuery dialogs

        $("#jDialog_default").dialog({autoOpen: false});        
        $("#jDialog_default_button").click(function(){
            $("#jDialog_default").dialog('open');
        });
        
        $("#jDialog_modal").dialog({autoOpen: false, modal: true});        
        $("#jDialog_modal_button").click(function(){
            $("#jDialog_modal").dialog('open');
        });        
        
        $("#jDialog_form").dialog({autoOpen: false, 
                                modal: true,
                                width: 400,
                                buttons: {
                                    "Submit": function() {
										 $( this ).dialog( "close" );
                                    },
                                    Cancel: function() {
                                        $( this ).dialog( "close" );
                                    }
        }});
    
        $("#jDialog_form_button").click(function(){$("#jDialog_form").dialog('open')});        
        
        
        
    // eof dialogs
    
    // dataTable
        if($(".table").length > 0)
            $(".table").dataTable({bFilter: false, bInfo: false, bPaginate: false, bLengthChange: false,                                                                       
                                   bSort: true,
                                   bAutoWidth: true,
                                   "aoColumnDefs": [{"bSortable": false,
                                                     "aTargets": [ -1 , 0]}]});
        if($(".fTable").length > 0)
            $(".fTable").dataTable({bSort: true, 
                                    "iDisplayLength": 20, "aLengthMenu": [5,10,20,25,50,100], // can be removed for basic 10 items per page
                                    "aoColumnDefs": [{"bSortable": false,
                                                     "aTargets": [ -1 , 0]}]});
        
        if($(".fpTable").length > 0)
            $(".fpTable").dataTable({bSort: true, 
                                    "iDisplayLength": 20, "aLengthMenu": [5,10,20,25,50,100], // can be removed for basic 10 items per page
                                    "sPaginationType": "full_numbers",
                                    "aoColumnDefs": [{"bSortable": false,
                                                     "aTargets": [ -1 , 0]}]});
        if($(".lookupItems").length > 0)
            $(".lookupItems").dataTable({bSort: true, 
                                    "iDisplayLength": 10, "aLengthMenu": [5,10,20,25,50,100], // can be removed for basic 10 items per page
                                    "sPaginationType": "full_numbers",
                                    "aoColumnDefs": [{"bSortable": false,
                                                     "aTargets": [ -1 , 0]}]});
        
        if($(".aTable").length > 0)
            $(".aTable").dataTable({bSort: true,                                     
                                    "sPaginationType": "full_numbers",
                                    "bProcessing": true,
                                    "sAjaxSource": 'php/ajax_datatable.php'});
        
    // eif dataTable
    
    // media         
    if($("#video").length > 0){        
        var video = new MediaElementPlayer('#video',{
            success: function(media, node, player){                   
                var events = ['loadstart', 'play','pause', 'ended'];
                
                for (var i=0, il=events.length; i<il; i++) {
                    media.addEventListener(events[i], function(e) {
                            notify('Video','#video: '+ e.type);
                    });                    
                }      
                
            }
        });                        
        
        $("#videoPlay").click(function(){            
            video.play();
        });
        $("#videoPause").click(function(){            
            video.pause();
        });
    }

    $('audio,video').mediaelementplayer();
    // eof media
    
    //wysiwyg editor
    if($("#wysiwyg").length > 0){
        wEditor = $("#wysiwyg").cleditor({width:"100%", height:"300px"});
    }          
    if($("#mail_wysiwyg").length > 0)
        m_editor = $("#mail_wysiwyg").cleditor({width:"100%", height:"100%",controls:"bold italic underline strikethrough | font size style | color highlight removeformat | bullets numbering | outdent alignleft center alignright justify"})[0].focus();    
    
    // eof wysiwyg editor
    
    //syntax highlight
    SyntaxHighlighter.defaults['toolbar'] = false;
    SyntaxHighlighter.all();    
    //eof syntax highlight
    
    // easy pie chart
    $('.epc .epc-green').easyPieChart({animate: 1000,barColor: '#468847',trackColor: '#FFFFFF',scaleColor: '#888888',lineWidth: '5',lineCap: 'square'});
    $('.epc .epc-orange').easyPieChart({animate: 1000, barColor: '#F89406',trackColor: '#FFFFFF',scaleColor: '#888888',lineWidth: '5',lineCap: 'square'});
    $('.epc .epc-red').easyPieChart({animate: 1000,barColor: '#B94A48',trackColor: '#FFFFFF',scaleColor: '#888888',lineWidth: '5',lineCap: 'square'});    
    
    $('.epc .epcm-green').easyPieChart({animate: 1000,barColor: '#468847',trackColor: '#FFFFFF',scaleColor: '#888888',lineWidth: '5',lineCap: 'square',size: 90});
    $('.epc .epcm-orange').easyPieChart({animate: 1000, barColor: '#F89406',trackColor: '#FFFFFF',scaleColor: '#888888',lineWidth: '5',lineCap: 'square',size: 90});
    $('.epc .epcm-red').easyPieChart({animate: 1000,barColor: '#B94A48',trackColor: '#FFFFFF',scaleColor: '#888888',lineWidth: '5',lineCap: 'square',size: 90});        
    // eof easy pie chart

    // file tree
    /*if($("#fileTree").length > 0){
        $("#fileTree").fileTree({ root: '../../assets/filetree/', script: 'php/filetree/jqueryFileTree.php' }, function(file) { 
            notify('File Tree','File: '+file);            
        });        
    }*/
    // eof file tree
    
    // File uploader
    if($("#uploader_v5").length > 0){
        $("#uploader_v5").pluploadQueue({		
                runtimes : 'html5',
                url : 'php/pluploader/upload.php',
                max_file_size : '1mb',
                chunk_size : '1mb',
                unique_names : true,
                dragdrop : true,
                resize : {width : 320, height : 240, quality : 100},
                filters : [
                        {title : "Image files", extensions : "jpg,gif,png"},
                        {title : "Zip files", extensions : "zip"}
                ],
                FilesAdded: function(editor,files){
                    alert(files);
                }
        });
    }
    if($("#uploader_v4").length > 0){
        $("#uploader_v4").pluploadQueue({		
                runtimes : 'html4',
                url : 'php/pluploader/upload.php',
                unique_names : true,
                filters : [
                        {title : "Image files", extensions : "jpg,gif,png"},
                        {title : "Zip files", extensions : "zip"}
                ]
        });
    }   
    // eof file uploader
    
    // sparklines 
        // line
        $(".spl").sparkline('html',{width: 100, height: 30, lineColor: '#30557f', fillColor: '#FFFFFF', disableHiddenCheck: true});
        $(".splr").sparkline('html',{width: 100, height: 30, lineColor: '#b84b48', fillColor: '#FFFFFF', disableHiddenCheck: true});
        $(".splg").sparkline('html',{width: 100, height: 30, lineColor: '#438758', fillColor: '#FFFFFF', disableHiddenCheck: true});
    
        // bar
        $(".spb").sparkline('html',{type: 'bar', width: 100, height: 30, barColor: '#30557f', disableHiddenCheck: true});
        $(".spbr").sparkline('html',{type: 'bar', width: 100, height: 30, barColor: '#b84b48', disableHiddenCheck: true});
        $(".spbg").sparkline('html',{type: 'bar', width: 100, height: 30, barColor: '#438758', disableHiddenCheck: true});   
        
        // discrete
        $(".spd").sparkline('html',{type: 'discrete', width: 100, height: 30, lineColor: '#30557f', disableHiddenCheck: true});
        $(".spdr").sparkline('html',{type: 'discrete', width: 100, height: 30, lineColor: '#b84b48', disableHiddenCheck: true});
        $(".spdg").sparkline('html',{type: 'discrete', width: 100, height: 30, lineColor: '#438758', disableHiddenCheck: true});       
        
        // pie
        $(".spp").sparkline('html',{type: 'pie', width: 30, height: 30,sliceColors:['#30557f','#b84b48','#438758','#f29514','#d1e79e','#f7f8fa'], disableHiddenCheck: true});
        $(".sppr").sparkline('html',{type: 'pie', width: 30, height: 30,sliceColors:['#b84b48','#30557f','#438758','#f29514','#d1e79e','#f7f8fa'], disableHiddenCheck: true});
        $(".sppg").sparkline('html',{type: 'pie', width: 30, height: 30,sliceColors:['#438758','#b84b48','#30557f','#f29514','#d1e79e','#f7f8fa'], disableHiddenCheck: true});
            
    // eof sparklines
    

});
$(window).load(function(){
    
    // Gallery Grid    
    if($(".gGallery").length>0){        
      
      $('.gGallery li').wookmark({autoResize: true,        
                                  offset: 5,
                                  container: $('.gGallery'),
                                  itemWidth: 110});
    }    
    
    // custom scrollbar        
        $(".scroll").mCustomScrollbar();
    // eof custom scrollbar    
    
});

$('.wrapper').resize(function(){

    if($("#wysiwyg").length > 0) editor.refresh();
    if($("#mail_wysiwyg").length > 0) m_editor.refresh();
    
});


function notify(title, text){
    $.pnotify({
        title: title,
        text: text,
        addclass: 'custom',
        hide: true,
        opacity: .8,
        nonblock: true,
        nonblock_opacity: .5
    });            
}

function resetForm()
{
	$('#validate')[0].reset();
}