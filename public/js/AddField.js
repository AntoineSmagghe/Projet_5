class AddField
{
    constructor(addBtn, ulElement, data_prototype, inputs, inputAttributeId, inputAttributeName, delBtnClassName){
        this.addBtn = addBtn;
        this.ulElement = ulElement;
        this.data_prototype = data_prototype;
        this.inputs = inputs;
        this.inputAttributeId = inputAttributeId;
        this.inputAttributeName = inputAttributeName;
        this.delBtnClassName = delBtnClassName;
        this.index = 0;
    }

    indexValue(){
        this.index = this.ulElement.children.length;
        if (this.index > 0){
            for (let i = 0; i < this.inputs.length; i++){
                this.inputs[i].setAttribute("id", this.inputAttributeId + "_" + i);
                this.inputs[i].setAttribute("name", this.inputAttributeName + "[" + i + "]");
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
        delBtn.setAttribute("class", this.delBtnClassName);
        delBtn.setAttribute("type", "button");
        delBtn.textContent = "X";
        return delBtn;
    }

    addRemover(){
        let input = document.getElementById(this.inputAttributeId + "_" + this.index);
        input.parentElement.parentElement.appendChild(this.createDelBtn());
        this.remover();
    }

    remover(){
        let removeBtn = document.getElementsByClassName(this.delBtnClassName);
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