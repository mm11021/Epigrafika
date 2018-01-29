var napravljena = false;

function prikaziTastaturu()
{
  if(!napravljena)
  {
    var node = document.getElementById("ABCD");
    var tastatura = document.createElement("div");
    tastatura.id = "keyboard";
    tastatura.style.margin = "auto";
    tastatura.style.width = sirina;
    node.appendChild(tastatura);
    createKeyboard(language);
    var x = document.createElement("div");
    x.id = "ispod";
    x.style.height = "20px";
    node.appendChild(x);
    napravljena = true;
  }
  else
  {
    var tastatura = document.getElementById("keyboard");
    var parent = tastatura.parentNode;
    parent.removeChild(tastatura);
    var x = document.getElementById("ispod");
    parent = x.parentNode;
    parent.removeChild(x);
    napravljena = false;
  }
  if(poslednjiFokusiran != undefined)
    poslednjiFokusiran.focus();
}
