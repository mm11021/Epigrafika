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
var poslednjiFokusiran;

function regenerateKeyboard(lang)
{
  var tastatura = document.getElementById("keyboard");
  var parent = tastatura.parentNode;
  parent.removeChild(tastatura);
  tastatura = document.createElement("div");
  tastatura.id = "keyboard";
  tastatura.style.margin = "auto";
  tastatura.style.backgroundColor = "red";
  tastatura.style.width = "450px";
  parent.appendChild(tastatura);
  createKeyboard(lang);
}

function createButton(id)
{
  var button = document.createElement("button");
  button.id = id;
  button.innerHTML = id;
  button.unos = poslednjiFokusiran;
  button.onclick = function()
  {
    this.unos = poslednjiFokusiran;
    if(this.unos == undefined)
      return;
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
        regenerateKeyboard(language);
        break;
      case "Caps":
        caps = !caps;
        regenerateKeyboard(language);
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
          regenerateKeyboard(language);
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
          regenerateKeyboard(language);
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
          regenerateKeyboard(language);
        }
        else text = slovo;
        break;
    }
	// ukoliko element na kome je fokus nije za unos, funckija ne treba da radi nista
    if(this.unos.tagName != "INPUT" && this.unos.tagName != "TEXTAREA")
      return;
    if(this.unos.tagName == "INPUT" && this.unos.type != "text")
      return;
    // ovo sluzi da se tekst ne unosi uvek na kraj polja, vec na mesto na kome se nalazi kursor
    var start = this.unos.selectionStart;
    var end = this.unos.selectionEnd;
    if(text != "" && start>=0)
    {
      var pocetak = this.unos.value.substr(0,start); // deo reci pre kursora (tj. pre selektovanog dela teksta)
      var kraj = this.unos.value.substr(end); // deo reci posle kursora (tj. posle selektovanog dela teksta)
      this.unos.value = pocetak+text+kraj;
      start++; // ako je ukucan neki simbol, fokus se treba postaviti posle tog slova
      this.unos.setSelectionRange(start,start); // vraca se kursor tamo gde je bio
    }
    else this.unos.setSelectionRange(start,end);
  };
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
            {
              var slovo=key[id][letter];
              if(shift != caps)
                slovo = slovo.toUpperCase();
              if(transformisani[slovo] != undefined)
                if(kapica || akcenat)
                  slovo = transformisani[slovo][0];
                else if(umlaut)
                  slovo = transformisani[slovo][1];
              createButton(slovo);
            }
    }
    document.getElementById("keyboard").appendChild(document.createElement("br"));
  }
}