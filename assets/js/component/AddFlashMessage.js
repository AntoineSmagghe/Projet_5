export default class AddFlashMessage
{
    constructor(message, label, insertElt)
    {
        this.message = message;
        this.label = label;
        this.insertElt = insertElt;
    }

    constructDomElt()
    {
        let div = document.createElement('div');
        div.setAttribute("class", "flash_message");

        let p = document.createElement('p');
        p.setAttribute("class", "flash-" + this.label)
        p.textContent = this.message;
        this.insertElt.appendChild(div).appendChild(p);
        this.addListener();
    }

    addListener()
    {
        let flash;
        for (let i in document.getElementsByClassName("flash_message")){
            flash = new Flash(document.getElementsByClassName("flash_message")[i], "blurOut");
            flash.init();
        }
    }

    init()
    {
        this.constructDomElt();
    }
}