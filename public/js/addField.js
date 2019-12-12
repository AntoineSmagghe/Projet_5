class addField
{
    constructor(addBtn, ulElement, data_prototype){
        this.addBtn = addBtn;
        this.ulElement = ulElement;
        this.data_prototype = data_prototype;
        this.index = 0;
        this.delBtn;
    }

    indexValue(){
        this.index = this.ulElement.children.length;
    }
    
    builder(){
        this.addBtn.addEventListener("click", ()=>{
            let indexedPrototype = this.data_prototype.replace(/__name__/g, this.index);
            let newLi = document.createElement("li");
            this.delBtn = document.createElement("button");
            this.delBtn.setAttribute("class", "btn_del_sets");
            this.delBtn.textContent = "supprimer.";
            
            newLi.appendChild(this.delBtn);
            newLi.insertAdjacentHTML('afterbegin', indexedPrototype);
            /*
            let node = new DOMParser().parseFromString(indexedPrototype, "text/html");
            let nodeInput = node.getElementsByTagName('input')[0];
            nodeInput.id = "article_api_data_" + this.index;
            nodeInput.name = "article[api_data][" + this.index + "]";
            newLi.appendChild(nodeInput);
            */
            this.ulElement.appendChild(newLi);
            this.remover();
            this.index++;
        });
    }

    remover(){
        let removeBtn = document.getElementsByClassName("btn_del_sets");
        for (let i = 0; i < removeBtn.length; i++){
            removeBtn[i].addEventListener("click", (e)=>{
                e.target.parentNode.parentNode.removeChild(e.target.parentNode);
            });
        }
    }
    
    init(){
        this.indexValue();
        this.builder();
    }
}