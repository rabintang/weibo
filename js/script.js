$(document).ready(function(){
    jQuery.fn.anim_progressbar = function (aOptions) {
        // def values
        var iCms = 1000;
        var iMms = 60 * iCms;
        var iHms = 3600 * iCms;
        var iDms = 24 * 3600 * iCms;

        // def options
        var aDefOpts = {
            start: new Date(), // now
            finish: new Date().setTime(new Date().getTime() + 3 * iCms), // now + 60 sec
            interval: 10
        }
        var aOpts = jQuery.extend(aDefOpts, aOptions);
        var vPb = this;

        // each progress bar
        return this.each(
            function() {
                var iDuration = aOpts.finish - aOpts.start;

                // calling original progressbar
                $(vPb).children('.pbar').progressbar();

                // looping process
                var vInterval = setInterval(
                    function(){
                        var iElapsedMs = new Date() - aOpts.start, // elapsed time in MS

                            iPerc = (iElapsedMs > 0) ? iElapsedMs / iDuration * 100 : 0; // percentages

                        $(vPb).children('.pbar').children('.ui-progressbar-value').css('width', iPerc+'%');
						if(iPerc >= 100)
						{
							window.location.href="./main.php";
						}
                      
                    } ,aOpts.interval
                );
            }
        );
    }

    // default mode
    $('#progress1').anim_progressbar();

});