var napravljena = false;

function prikaziTastaturu()
{
  if(!napravljena)
  {
    var node = document.getElementById("ABCD");
    var tastatura = document.createElement("div");
    tastatura.id = "keyboard";
    node.appendChild(tastatura);
    createKeyboard(language);
    napravljena = true;
  }
  else
  {
    var tastatura = document.getElementById("keyboard");
    var parent = tastatura.parentNode;
    parent.removeChild(tastatura);
    napravljena = false;
  }
  if(poslednjiFokusiran != undefined)
    poslednjiFokusiran.focus();
}
