<html>
<script>
var game = "<?php echo $_GET['game'];?>";
var player = {};

window.addEventListener('load',getOldData);

function getLC(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return 0;
}

function getLS(cname) {
    var loc = localStorage.getItem(cname);
    if (loc) return loc;
    else return 0;
}

function setLC(cname, cvalue, del = 1) {
    var d = new Date();
    d.setTime(d.getTime() + (parseFloat(del) * (90 * 24 * 60 * 60 * 1000)));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/; SameSite=None; Secure";
}

function getOldData() {
    //Gets 1st generation data from Cookies
    if (getLS(game) == 0 && getLC(game) != 0) {
	    player.level = getLC(game);
		setLC(game, "", -1);
		player.mode = getLC(game+"_mode");
		setLC(game + "_mode", "", -1);
		player.score = getLC(game+"_score"); 
		setLC(game + "_score", "", -1); 
    }else{
	//Gets 2nd generation data from Local Storage raduanastase.com
		player.level = getLS(game);
		localStorage.removeItem(game);
		player.score = getLS(game+"_score"); 
		localStorage.removeItem(game+"_score");
		player.mode = getLS(game+"_mode"); 
		localStorage.removeItem(game+"_mode");
	}
	//Sends data to parent
    var playerdata = JSON.stringify(player);
    window.parent.postMessage(playerdata, '*');
	console.log(playerdata);
}
</script>
</html>