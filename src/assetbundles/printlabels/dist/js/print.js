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
    if(dymo_printer !== ''){
        $('#details .order-info-box').before('<a href="#" class="printlabel btn small">PRINT SHIPPING LABEL (DYMO)</a>');
    } 
    
    $('.printlabel').click(function(){
        var orderId = $('input[name="orderId"]').val();
        var addressLabel;
        if(orderId){
            $.get("/admin/printlabels", { orderId: orderId } )
            .done(function( data ) {
                var textTextArea = data.replace(/<br>/g, "\n");
                printLabel(textTextArea);        
				location.reload();				
            });
        }
    })
    
    $('.printtest').click(function(){
        var textTextArea = 'firstName lastName\n'+'Street 12345\n'+'Zipcode City\n';
        printLabel(textTextArea);  
    })
})

function printLabel(textTextArea)
{
    if(dymo.label.framework.init) {
		dymo.label.framework.init(doPrint);			
	}
    
    function doPrint(){
        
        var labelXml = '<?xml version="1.0" encoding="utf-8"?>\
                        <DieCutLabel Version="8.0" Units="twips">\
                            <PaperOrientation>Landscape</PaperOrientation>\
                            <Id>Address</Id>\
                            <PaperName>30252 Address</PaperName>\
                            <DrawCommands>\
                                <RoundRectangle X="0" Y="0" Width="1581" Height="5040" Rx="270" Ry="270" />\
                            </DrawCommands>\
                            <ObjectInfo>\
                                <AddressObject>\
                                <Name>Address</Name>\
                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                                <LinkedObjectName></LinkedObjectName>\
                                <Rotation>Rotation0</Rotation>\
                                <IsMirrored>False</IsMirrored>\
                                <IsVariable>True</IsVariable>\
                                <HorizontalAlignment>Left</HorizontalAlignment>\
                                <VerticalAlignment>Middle</VerticalAlignment>\
                                <TextFitMode>ShrinkToFit</TextFitMode>\
                                <UseFullFontHeight>True</UseFullFontHeight>\
                                <Verticalized>False</Verticalized>\
                                <StyledText>\
                                <Element>\
                                <String>'+textTextArea+'</String>\
                                <Attributes>\
                                <Font Family="'+dymo_fonttype+'" Size="'+dymo_fontsize+'" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                </Attributes>\
                                </Element>\
                                </StyledText>\
                                <ShowBarcodeFor9DigitZipOnly>False</ShowBarcodeFor9DigitZipOnly>\
                                <BarcodePosition>BelowAddress</BarcodePosition>\
                                <LineFonts>\
                                    <Font Family="'+dymo_fonttype+'" Size="'+dymo_fontsize+'" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                </LineFonts>\
                                </AddressObject>\
                                <Bounds X="332" Y="150" Width="4455" Height="1260" />\
                            </ObjectInfo>\
                        </DieCutLabel>';
        
        var label = dymo.label.framework.openLabelXml(labelXml);
        var printers = dymo.label.framework.getPrinters();
        if (printers.length === 0){
            alert("No DYMO printers are installed. Install DYMO printers.");
            return;
        } else {
            var printerName = ''; 
            for (var i = 0; i < printers.length; ++i)
            {
                var printer = printers[i];
                if (printer.printerType == "LabelWriterPrinter")
                {
                    if(printer.name==dymo_printer){
                        printerName = printer.name;
                        break;
                    }
                }
            }
            label.print(printerName);
        }
    }
}
