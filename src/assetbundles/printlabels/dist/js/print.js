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
    if(dymo_printer !== '' && dymo_labelId !== ''){
        $('#details .order-info-box').before('<a href="#" class="printlabel btn small">PRINT SHIPPING LABEL (DYMO)</a>');
    } 
    
    $('.printlabel').click(function(){
        var orderId = $('input[name="orderId"]').val();
        if(orderId){
            $.get("/admin/printlabels", { orderId: orderId } )
            .done(function( data ) {
                var textTextArea = data.replace(/<br>/g, "\n");
                printLabel(textTextArea, dymo_labelId);        
				location.reload();				
            });
        }
    })
    
    $('.printtest').click(function(){
        var textTextArea = 'firstName lastName\n'+'Street 12345\n'+'Zipcode City\n'+'Country\n';
        printLabel(textTextArea, dymo_labelId);  
    })
})

function printLabel(textTextArea, dymo_labelId)
{
    if(dymo.label.framework.init) {
		dymo.label.framework.init(doPrint);			
	}
    
    function doPrint(){
		
        var PaperName;
        var width;
        var height;
        var boundX;
        var boundY;			
        var boundWidth;
        var boundHeight;
        
		if(dymo_labelId == 'Address'){
			PaperName = '30252 Address';
			width = 1581;
			height = 5040;
			boundX = 332;
			boundY = 150;			
			boundWidth = 4455;
			boundHeight = 1260;
		} else {
			PaperName = '30321 Large Address';
			width = 2025;
			height = 5020;
			boundX = 322;
			boundY = 57.9999999999999;			
			boundWidth = 4613;
			boundHeight = 1882;
		}
		
        var labelXml = '<?xml version="1.0" encoding="utf-8"?>\
                        <DieCutLabel Version="8.0" Units="twips">\
                            <PaperOrientation>Landscape</PaperOrientation>\
                            <Id>'+dymo_labelId+'</Id>\
                            <PaperName>'+PaperName+'</PaperName>\
                            <DrawCommands>\
							<RoundRectangle X="0" Y="0" Width="'+width+'" Height="'+height+'" Rx="270" Ry="270" />\
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
                                <Bounds X="'+boundX+'" Y="'+boundY+'" Width="'+boundWidth+'" Height="'+boundHeight+'" />\
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
