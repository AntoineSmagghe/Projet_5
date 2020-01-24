class AddField
{
    constructor(addBtn, ulElement, data_prototype){
        this.addBtn = addBtn;
        this.ulElement = ulElement;
        this.data_prototype = data_prototype;
        this.index = 0;
    }

    indexValue(){
        this.index = this.ulElement.children.length;
        if (this.index > 0){
            let inputs = document.getElementsByClassName("url_SC");
            for (let i = 0; i < inputs.length; i++){
                inputs[i].setAttribute("id", "article_api_data_" + i);
                inputs[i].setAttribute("name", "article[api_data][" + i + "]");
            }
        }
    }

    builder(){
        this.addBtn.addEventListener("click", ()=>{
            let indexedPrototype = this.data_prototype.replace(/__name__/g, this.index);
            let newLi = document.createElement("li");
            let newDiv = document.createElement("div");
            newDiv.setAttribute("class", "form-group");
            newDiv.insertAdjacentHTML('beforeend', indexedPrototype);
    
            newLi.appendChild(newDiv);
            this.ulElement.appendChild(newLi);
            this.addRemover();
            this.index++;
        });
    }

    createDelBtn(){
        let delBtn = document.createElement("button");
        delBtn.setAttribute("class", "btn_del_sets");
        delBtn.setAttribute("name", this.index);
        delBtn.setAttribute("type", "button");
        delBtn.textContent = "X";
        return delBtn;
    }

    addRemover(){
        let input = document.getElementById("article_api_data_" + this.index);
        input.parentElement.parentElement.appendChild(this.createDelBtn());
        this.remover();
    }

    remover(){
        let removeBtn = document.getElementsByClassName("btn_del_sets");
        for (let i = 0; i < removeBtn.length; i++){
            removeBtn[i].addEventListener("click", (e)=>{
                e.target.parentElement.remove();
            });
        }
    }
    
    init(){
        this.indexValue();
        this.remover();
        this.builder();
    }
}