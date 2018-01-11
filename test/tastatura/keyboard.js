var keyboardJSON;
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200)
        keyboardJSON = JSON.parse(this.responseText);
};
xmlhttp.open("GET", "kb_langs.json", false);
xmlhttp.send();

var shift = false;
var caps = false;

function createButton(id)
{
  var button = document.createElement("button");
  button.id = id;
  button.innerHTML = id;
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
		var tastatura = document.getElementById("keyboard");
		var parent = tastatura.parentNode;
		parent.removeChild(tastatura);
		tastatura = document.createElement("div");
        tastatura.id = "keyboard";
		parent.appendChild(tastatura);
		createKeyboard(language);
		text = "";
		break;
	  case "Caps":
	    caps = !caps;
		var tastatura = document.getElementById("keyboard");
		var parent = tastatura.parentNode;
		parent.removeChild(tastatura);
		tastatura = document.createElement("div");
        tastatura.id = "keyboard";
		parent.appendChild(tastatura);
		createKeyboard(language);
		text = "";
		break;
	  default:
	    // neophodno je da se ne bi ispisivalo &amp; i slicno
	    var parser = new DOMParser;
		var dom = parser.parseFromString("<!DOCTYPE html><body>"+this.innerHTML,"text/html");
		text = dom.body.textContent;
    }
	var textBox = document.getElementById("textbox");
	textBox.value += text;
  }
  document.getElementById("keyboard").appendChild(button);
}
function createKeyboard(lang)
{
  var kb = keyboardJSON[lang];
  for(row in kb)
  {
	  var kbrow = kb[row];
	  for(keys in kbrow)
	  {
		  var key = kbrow[keys];
		  if(typeof key == "string")
			  createButton(key);
		  else
			  for(id in key)
				  if(id!="letters")
					  if(shift)
						  createButton(key[id]);
					  else createButton(id);
				  else
					  for(letter in key[id])
						  if(shift == caps)
							  createButton(key[id][letter]);
						  else createButton(key[id][letter].toUpperCase());
	  }
	  document.getElementById("keyboard").appendChild(document.createElement("br"));
  }
}
var language = "french";
var tastatura = document.createElement("div");
tastatura.id = "keyboard";
document.body.appendChild(tastatura);
createKeyboard(language);
document.getElementById("keyboard").appendChild(document.createElement("br"));
var textBox = document.createElement("input");
textBox.id = "textbox";
textBox.type = "text";
document.body.appendChild(textBox);