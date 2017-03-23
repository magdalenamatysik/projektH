/**
 * Created by admin on 2016-10-25.
 */







var modal = document.getElementById('add_task_model');

var btn = document.getElementById("task");

var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
    modal.style.display = "block";
}

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }



