class AddFlashMessage
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
        div.setAttribute("id", "flash_message");

        let p = document.createElement('p');
        p.setAttribute("class", "flash-" + this.label)
        p.textContent = this.message;
        this.insertElt.appendChild(div.appendChild(p));

        this.addListener();
    }

    addListener()
    {
        const flash = new Flash(document.getElementById("flash_message"), "blurOut");
        flash.init();
    }

    init()
    {
        this.constructDomElt();
    }
}