$(document).ready(function(){
    tl = new TimelineLite();
    var form = $(".input-contain"),
        sub = $(".submit-under"),
        allsub = $(".allsub"),
        loader = $(".loader circle"),
        loader2 = $(".loader2 circle"),
        loaders = [loader, loader2],
        circP = $(".circle-paper");

    $(".submit").on("click", function(e) {
        // var emetteur = document.querySelector('#nom').value;
        // var emetteurEmail = document.querySelector('#transmitter_email').value;
        // var destinataire = document.querySelector('#firstname').value;
        
        // if(emetteur != "" && emetteurEmail != "" && destinataire != "") {
            TweenMax.set(sub, {opacity:0.7, rotationY:90});
            TweenMax.set($(".submit-under, .loader, .loader2, .circle-paper, p.success-dialog, h2.success"), {display:"block"});
            //TweenMax.set(loader, {drawSVG:'100% 100%', rotation:-90});
            TweenMax.set(circP, {scaleY:0, transformOrigin:"50% 50%"});
            TweenMax.set([loader2, circP], {opacity:0});
            TweenMax.set($(".success, .success-dialog"), {opacity:0});

            e.preventDefault;
            tl.to(sub, 1, {opacity:1, rotationY:0, ease:Expo.easeOut});
            tl.add("flip");
            tl.to($(".submit"), 0.5, {rotationX:90, ease:Circ.easeOut}, "flip-=1.5");
            tl.to($(".submit"), 0.5, {opacity:0}, "flip-=0.5");
            tl.to(sub, 0.25, {css:{borderRadius: "50%", backgroundColor:"#d6312d"}, ease:Circ.easeOut}, "flip-=0.5");
            tl.to(sub, 1.2, {scaleX:0.16,  transformOrigin:"50% 50%", ease:Expo.easeOut}, "flip-=0.5");
            tl.fromTo(loader, 1, {transformOrigin:"50% 50%", drawSVG:"50% 50%"}, {transformOrigin:"50% 50%", drawSVG:"100%"}, "flip+=1");
            tl.to(sub, 0.8, {rotationX:90, scaleY:0}, "flip+=1.2");
            tl.to(loader2, 0.1, {opacity:1}, "flip+=1.8");
            tl.to(loader2, 0.5, {opacity:1, transformOrigin:"50% 50%", scaleX:0, rotation:180}, "flip+=2");
            tl.to(loader2, 0.5, {opacity:1, transformOrigin:"50% 50%", scaleX:1, rotation:180}, "flip+=2.5");
            tl.add("success");
            tl.to($(".circle-quill"), 0.5, {scaleY:0, transformOrigin:"50% 50%", ease:Circ.easeOut}, "success");
            tl.to(circP, 0.5, {scaleY:1, opacity:1, transformOrigin:"50% 50%", ease:Circ.easeIn}, "success");
            tl.to($(".circle-quill"), 0.5, {scaleY:0, transformOrigin:"50% 50%", ease:Circ.easeOut}, "success");
            tl.to($("input,textarea,#my-awesome-dropzone"), 0.5, {scaleY:0}, "success");
            tl.to($(".info"), 0.5, {scaleY:0}, "success");
            tl.to($(".success"), 0.5, {scaleY:1, opacity: 1}, "success+=1");
            tl.to($(".success-dialog"), 1, {opacity: 1}, "success+=1");
            tl.to(loaders, 0.5, {scaleY:0, stroke:"#d6312d", transformOrigin:"50% 50%"}, "success");
            tl.to(form, 0.5, {css:{backgroundColor:"#faf5f3"}}, "success");
        // }
    });
    
});


$(document).ready(function(){
    Dropzone.options.myAwesomeDropzone = {
        maxFilesize: 5,
        addRemoveLinks: true,
        dictResponseError: 'Server not Configured',
        acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
        init:function(){
            var self = this;
            // config
            self.options.addRemoveLinks = true;
            self.options.dictRemoveFile = "Delete";
            //New file added
            self.on("addedfile", function (file) {
                console.log('new file added ', file);
            });
            // Send file starts
            self.on("sending", function (file) {
                console.log('upload started', file);
                $('.meter').show();
            });

            // File upload Progress
            self.on("totaluploadprogress", function (progress) {
                console.log("progress ", progress);
                $('.roller').width(progress + '%');
            });

            self.on("queuecomplete", function (progress) {
                $('.meter').delay(999).slideUp(999);
            });

            // On removing file
            self.on("removedfile", function (file) {
                console.log(file);
            });
        }
    };
});