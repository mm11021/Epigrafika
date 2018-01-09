var firstRow = ["q","w","e","r","t","y","u","i","o","p"];
var secondRow = ["a","s","d","f","g","h","j","k","l"];
var thirdRow = ["z","x","c","v","b","n","m"];
var shiftKeys = {"`":"~", "1":"!", "2":"@", "3":"#", "4":"$", "5":"%", "6":"^", "7":"&", "8":"*", "9":"(", "0":")", "-":"_", "=":"+",
                 "[":"{", "]":"}", ";":":", "'":'"', "\\":"|", ",":"<", ".":">", "/":"?"}
var shift = false;
var caps = false;
function setInnerHTML(id)
{
	if(shift)
    {
	  if(shiftKeys[id]!=undefined)
	    return shiftKeys[id];
      else if(!caps && id.length==1)
		return id.toUpperCase();
    }
    else if(caps && id.length==1)
		return id.toUpperCase();
	return id;
}
function createButton(id)
{
  var button = document.createElement("button");
  button.id = id;
  button.innerHTML = setInnerHTML(id);
  button.onclick = function()
  {
	var text;
	switch(id)
	{
	  case "Space":
	    text = " ";
		break;
      case "Tab":
	    text = "\t";
		break;
	  case "LShift":
	  case "RShift":
	    shift = !shift;
		var buttons=document.getElementsByTagName("button");
		for(i=0;i<buttons.length;i++)
		  buttons[i].innerHTML=setInnerHTML(buttons[i].id);
		text = "";
		break;
	  case "Caps":
	    caps = !caps;
		var buttons=document.getElementsByTagName("button");
		for(i=0;i<buttons.length;i++)
		  buttons[i].innerHTML=setInnerHTML(buttons[i].id);
		text = "";
		break;
	  default:
	    text = this.innerHTML;
    }
	var textBox = document.getElementById("textbox");
	textBox.value += text;
  }
  document.body.appendChild(button);
}
function createKeyboard()
{
  createButton("`");
  for(i=1;i<=9;i++)
    createButton(i);
  createButton("0");
  createButton("-");
  createButton("=");
  document.body.appendChild(document.createElement("br"));
  createButton("Tab");
  for(key in firstRow)
    createButton(firstRow[key]);
  createButton("[");
  createButton("]");
  document.body.appendChild(document.createElement("br"));
  createButton("Caps");
  for(key in secondRow)
    createButton(secondRow[key]);
  createButton(";");
  createButton("'");
  createButton("\\");
  document.body.appendChild(document.createElement("br"));
  createButton("LShift");
  for(key in thirdRow)
    createButton(thirdRow[key]);
  createButton(",");
  createButton(".");
  createButton("/");
  createButton("RShift");
}
createKeyboard();
document.body.appendChild(document.createElement("br"));
var textBox = document.createElement("input");
textBox.id = "textbox";
textBox.type = "text";
document.body.appendChild(textBox);