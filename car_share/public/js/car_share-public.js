(function($) {
    'use strict';
    /**
     * All of the code for your public-facing JavaScript source
     * should reside in this file.
     *
     * Note that this assume you're going to use jQuery, so it prepares
     * the $ function reference to be used within the scope of this
     * function.
     *
     * From here, you're able to define handlers for when the DOM is
     * ready:
     *
     * $(function() {
     *
     * });
     *
     * Or when the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and so on.
     *
     * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
     * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
     * be doing this, we should try to minimize doing that in our own work.
     */
 
    $(function() {
        
        var i;
        
        $("#car_datefrom").datepicker({
            minDate: 0,
            changeMonth: true,
            numberOfMonths: 2,
 
            onClose: function(selectedDate) {
                $("#car_dateto").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#car_dateto").datepicker({
            minDate: 0,
            changeMonth: true,
            numberOfMonths: 2,  
    
           
            onClose: function(selectedDate) { 
                $("#car_datefrom").datepicker("option", "maxDate", selectedDate); 
            }
        }); 
    });
   
 
   
  
  $("#returnlocationcheck").click(function(event) {       
    if ($(this).is(":checked"))
      $("#car_drop_of_location").show('fast');
    else
      $("#car_drop_of_location").hide('fast');
  });
   
})(jQuery); 