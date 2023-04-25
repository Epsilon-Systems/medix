jQuery(document).ready(function($)
{

    var layoutOptions = Joomla.getOptions('com_joomtestimonials.testimonialslayout');
    var layoutType = layoutOptions.itemType;
    var layoutId = layoutOptions.itemId;
    var InputId = layoutOptions.InputId;

    $("#iframe").attr("data-iframe", $("#iframeHolder").data("iframe"));

    JtInitialise = function(){
        if($("#" + InputId).val().includes("_:")){
            $("#iframe").removeClass("disabled");
            JtUpdateUrl();
        }else{
            $("#iframe").addClass("disabled");
        }
    }

    JtUpdateUrl = function(){
        let layout = $("#" + InputId).val().substr(2);
        let href = $("#iframe").data("href");

        if(layoutType !== "global") {
            $("#" + InputId).attr("data-" + layoutType + "id", layoutId);
            href = href + "&" + layoutType +"Id=" + layoutId;
        }
        if(layoutType === "module") href = href + "&isModule=1" ;

        href = href + "&layout=" + layout;

        var iframeHolder = $("#iframeHolder");
        iframeHolder.attr("data-url", href);

        let dataIframe = $("#iframe").data("iframe");
        dataIframe = dataIframe.replace('src=""' , 'src="' + href + '" id="myIframe"');
        iframeHolder.attr("data-iframe", dataIframe);

        $(".modal-title").html("Customise " + layout + " layout");
    }

    JtInitialise();

    $("#" + InputId).change(function(){
        JtInitialise();
    });

});