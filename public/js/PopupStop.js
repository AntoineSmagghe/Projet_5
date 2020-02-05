/**
 * This take an dom element with getElementsByClassName
 * return a popup validation with a specific message.
 * If false = action is stopped.
 * 
 * @class PopupStop
 */

class PopupStop{
    constructor(domTarget, message, messageIfValidate){
        this.domTarget = domTarget;
        this.message = message;
        this.messageIfValidate = messageIfValidate;
    }

    validateAction(){
        this.domTarget.addEventListener("click", (e)=>{
            if (window.confirm(this.message)){
                alert(this.messageIfValidate);
            } else {
                e.preventDefault();
            }
        });
    }
}