class addField
{
    constructor(addBtn, ulElement, data_prototype){
        this.addBtn = addBtn;
        this.ulElement = ulElement;
        this.data_prototype = data_prototype;
        this.index = 0;
    }

    indexValue(){
        this.index = this.ulElement.children.length;
        this.data_prototype.setAttribute("index", this.index);
        this.data_prototype.replace("__name__", this.index);
    }

    builder(){
        this.addBtn.addEventListener("click", ()=>{
            let newLi = document.createElement("li");
            newLi.innerHTML = this.data_prototype;
            this.ulElement.appendChild(newLi);
            this.index++;
        });
    }
    
    init(){
        this.indexValue();
        this.builder();
    }
}