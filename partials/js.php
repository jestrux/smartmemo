<script src="js/jquery.min.js"></script>
<script src="js/scripts.js"></script>

<script>
    var textarea = document.getElementById("textarea");
    var heightLimit = 500;

    textarea.oninput = function() {
        textarea.style.height = ""; /* Reset the height*/
        textarea.style.height = Math.min(textarea.scrollHeight, heightLimit) + "px";
    };

    // getElementById
	function $id(id) {
		return document.getElementById(id);
    }
    
    function parentUpTo(el, tagName) {
        tagName = tagName.toLowerCase();

        while (el && el.parentNode) {
            el = el.parentNode;
            if (el.tagName && el.tagName.toLowerCase() == tagName) {
            return el;
            }
        }

        return null;
    }

    function deleteFile(file) {
        console.log("Deleting file...");
        return new Promise((resolve, reject) => {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function(e) {
                if (xhr.readyState == 4) {
                    // console.log(xhr.responseText);
                    if(xhr.status == 200){
                        resolve();
                    }else{
                        reject();
                    }
                }
            };

            xhr.open("POST", "unlink.php", true);
            // xhr.setRequestHeader("X-FILENAME", file);
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xhr.send(file);
        })
    }
    
    function showToast(msg, type, pos){
        var position = pos || 'top-center';
        var toast = document.createElement('div');
        toast.classList.add('toast');

        if(type){
            var icon = document.createElement('i');
            icon.classList.add('zmdi');
            icon.classList.add('inline-flex');
            toast.appendChild(icon);
            if(type === "success"){
                icon.classList.add('zmdi-check');
                toast.classList.add('success');
            }
            else if(type === "error"){
                icon.classList.add('zmdi-close');
                toast.classList.add('error');
            }
        }

        var html = toast.innerHTML;
        toast.innerHTML = html + msg;

        document.body.appendChild(toast);

        toast.classList.add(position);
        toast.classList.add("fade-in");

        setTimeout(() => {
            toast.classList.remove("fade-in");
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 400);
        }, 3000);
    }

    <?php 
        if (Notify::has_success()) {
            echo "showToast('" . Notify::get_success() . "', 'success')";
        } else if (Notify::has_error()) {
            echo "showToast('" . Notify::get_error() . "', 'error')";
        }
        Notify::restore();
    ?>
</script>