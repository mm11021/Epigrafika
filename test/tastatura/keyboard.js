var keyboardJSON;
var transformisani;
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200)
        keyboardJSON = JSON.parse(this.responseText);
};
xmlhttp.open("GET", "/test/tastatura/kb_langs.json", false);
xmlhttp.send();

xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200)
        transformisani = JSON.parse(this.responseText);
};
xmlhttp.open("GET", "/test/tastatura/kb_special.json", false);
xmlhttp.send();

var shift = false;
var caps = false;
var kapica = false;
var umlaut = false;
var akcenat = false;

function regenerateKeyboard(lang)//,textbox)
{
  var tastatura = document.getElementById("keyboard");
  var parent = tastatura.parentNode;
  parent.removeChild(tastatura);
  tastatura = document.createElement("div");
  tastatura.id = "keyboard";
  tastatura.style.margin = "auto";
  tastatura.style.backgroundColor = "red";
  tastatura.style.width = "430px";
  parent.appendChild(tastatura);
  createKeyboard(lang);//,textbox);
}

function createButton(id)//,textbox)
{
  var button = document.createElement("button");
  button.id = id;
  button.innerHTML = id;
  button.unos = document.activeElement;
  button.onclick = function()
  {
    this.unos.focus();
    var text = "";
    switch(id)
    {
      case "Space":
        if(kapica)
        {
          text = "^";
          kapica = false;
        }
        else text = " ";
        break;
      case "Tab":
        if(kapica)
        {
          text = "^";
          kapica = false;
        }
        else text = "\t";
        break;
      case "LShift":
      case "RShift":
        shift = !shift;
        regenerateKeyboard(language,textbox);
        break;
      case "Caps":
        caps = !caps;
        regenerateKeyboard(language,textbox);
        break;
      case "^":
      case "¨":
      case "΄":
        if(language == "french")
        {
          if(id == "^")
            kapica = true;
          else
          {
            umlaut = true;
            shift = false;
          }
          regenerateKeyboard(language,textbox);
          break;
        }
        if(language == "greek")
        {
          if(id == "¨")
          {
            umlaut = true;
            shift = false;
          }
          else akcenat = true;
          regenerateKeyboard(language,textbox);
          break;
        }
      default:
        // neophodno je da se ne bi ispisivalo &amp; i slicno
        var parser = new DOMParser;
        var dom = parser.parseFromString("<!DOCTYPE html><body>"+this.innerHTML,"text/html");
        var slovo = dom.body.textContent;
        if(kapica || umlaut || akcenat)
        {
          if("âÂêÊîÎôÔûÛäÄëËïÏöÖüÜάΆέΈήΉίΊόΌύΎώΏϊΪϋΫ".includes(slovo))
            text = slovo;
          else if(kapica)
            text = "^"+slovo;
          else if (umlaut)
            text = "¨"+slovo;
          else text = "΄"+slovo;
          kapica = umlaut = akcenat = false;
          regenerateKeyboard(language,textbox);
        }
        else text = slovo;
        break;
    }
    this.unos.value += text;
  };
  document.getElementById("keyboard").appendChild(button);
}
function createKeyboard(lang)//,textbox)
{
  var kb = keyboardJSON[lang];
  for(row in kb)
  {
    var kbrow = kb[row];
    for(keys in kbrow)
    {
      var key = kbrow[keys];
      if(typeof key == "string")
        createButton(key);//,textbox);
      else
        for(id in key)
          if(id!="letters")
            if(shift)
              createButton(key[id]);//,textbox);
            else createButton(id);//,textbox);
          else
            for(letter in key[id])
            {
              var slovo=key[id][letter];
              if(shift != caps)
                slovo = slovo.toUpperCase();
              if(transformisani[slovo]!=undefined)
                if(kapica || akcenat)
                  slovo = transformisani[slovo][0];
                else if(umlaut)
                  slovo = transformisani[slovo][1];
              createButton(slovo);//,textbox);
            }
    }
    document.getElementById("keyboard").appendChild(document.createElement("br"));
  }
}