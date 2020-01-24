class SelectRadio
{
    constructor(inputElt){
        this.inputElt = inputElt;
        this.checkIco = "";
        this.uncheckIco = "";
    }

    listenRadioButton(){
        for (let i = 0; i < this.inputElt.length; i++){
            this.inputElt[i].addEventListener("change", (e)=>{
                if(this.checkIco != "" && this.uncheckIco != ""){
                    document.getElementById(this.checkIco).style.display = 'none';
                    document.getElementById(this.uncheckIco).style.display = 'block';
                }
                this.checkIco = "check - " + e.target.id;
                this.uncheckIco = "uncheck - " + e.target.id;
                document.getElementById(this.checkIco).style.display = 'block';
                document.getElementById(this.uncheckIco).style.display = 'none';
            });
        }
    }

    init(){
        this.listenRadioButton();
    }
}