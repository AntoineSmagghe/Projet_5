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
    }
    
    builder(){
        this.addBtn.addEventListener("click", ()=>{
            let indexedPrototype = this.data_prototype.replace(/__name__/g, this.index);
            let newLi = document.createElement("li");
            newLi.innerHTML = indexedPrototype;
            /*
            let node = new DOMParser().parseFromString(indexedPrototype, "text/html");
            let nodeInput = node.getElementsByTagName('input')[0];
            nodeInput.id = "article_api_data_" + this.index;
            nodeInput.name = "article[api_data][" + this.index + "]";
            newLi.appendChild(nodeInput);
            */
            this.ulElement.appendChild(newLi);
            this.index++;
        });
    }
    
    init(){
        this.indexValue();
        this.builder();
    }
}