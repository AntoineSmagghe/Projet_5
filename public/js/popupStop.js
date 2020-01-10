/**
 * This take an dom element with getElementsByClassName
 * return a popup validation with a specific message.
 * If false = action is stopped.
 * 
 * @class popupStop
 */

class popupStop{
    constructor(domTarget, message, messageIfValidate){
        this.domTarget = domTarget;
        this.message = message;
        this.messageIfValidate = messageIfValidate;
    }

    validateAction(){
        this.domTarget.addEventListener("click", (e)=>{
            let isConfirmed = window.confirm(this.message);
            if (isConfirmed){
                alert(this.messageIfValidate);
            } else {
                e.preventDefault();
            }
        });
    }
}