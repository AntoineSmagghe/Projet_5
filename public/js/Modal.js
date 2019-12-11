class Modal
{
    constructor(modal, modalDisplay, background, openBtn, closeBtn = null){
        this.modal = modal;
        this.display = modalDisplay;
        this.background = background;
        this.openBtn = openBtn;
        this.closeBtn = closeBtn;
    }

    openModal(){
        this.openBtn.addEventListener("click", ()=>{
            this.background.style.display = "block";
            this.modal.style.display = this.display;
            this.closeModal();
        });
    }

    closeModal(){
        window.addEventListener("click", (e)=>{
            if (e.target == this.background){
                this.modal.style.display = "none";
                this.background.style.display = "none";
                this.openModal();
            }
        });
        
        if (closeBtn != null){
            this.closeBtn.addEventListener("click", (e)=>{
                e.stopPropagation();
                this.modal.style.display = "none";
                this.background.style.display = "none";
                this.openModal()
            });
        }
    }

    init(){
        this.openModal();
    }
}