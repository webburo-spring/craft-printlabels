/**
 * Print Labels plugin for Craft CMS
 *
 * Print Labels JS
 *
 * @author    Webburo Spring
 * @copyright Copyright (c) 2018 Webburo Spring
 * @link      https://www.webburo-spring.nl
 * @package   PrintLabels
 * @since     1.0.0
 */

$(document).ready(function(){
    getPrinter();    
})

function getPrinter(){
	var printers = dymo.label.framework.getPrinters();

    var option_printers ='';
    var selected_printer = '';
    if(printers.length  === 0){
        option_printers +='<option value="">No DYMO printers installed</option>';
    } else {
        option_printers +='<option value="">Select your DYMO Printer</option>';    
    }
		
	for (var i = 0; i < printers.length; ++i)
	{
		var printer = printers[i];
		
		if (printer.printerType == "LabelWriterPrinter")
		{
			if(printer.name == dymo_printer){
				selected_printer = ' SELECTED';
			}
            option_printers +='<option value="'+printer.name+'" '+selected_printer+'>'+printer.name+'</option>';
		}
	}
	
	$('#settings-dymoPrinter').html(option_printers);
}


