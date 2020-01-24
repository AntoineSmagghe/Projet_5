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
            if (!this.isMobile()) {
                this.modal.style.animation = "slideRight .5s ease";
            }
            this.background.style.display = "block";
            this.modal.style.display = this.display;

            this.closeModal();
        });
    }

    closeAction(e){
        if (e.target == this.background) {
            if (!this.isMobile()) {
                this.modal.style.animation = "slideRightReverse .5s ease";
                setTimeout(() => {
                    this.modal.style.display = "none";
                    this.background.style.display = "none";
                }, 400);
            } else {
                this.modal.style.display = "none";
                this.background.style.display = "none";
            }

            this.openModal();
        }
    }

    closeModal(){
        window.addEventListener("click", (e)=>{this.closeAction(e)});
        this.closeBtn.addEventListener("click", (e)=>{this.closeAction(e)});
        
        if (this.closeBtn != null){
            this.closeBtn.addEventListener("click", (e)=>{
                e.stopPropagation();
                this.modal.style.display = "none";
                this.background.style.display = "none";
                this.openModal()
            });
        }
    }

    isMobile() {
        let whatUser = navigator.userAgent;
        if (whatUser.match(/Android/i)
            || whatUser.match(/Iphone/i)
            || whatUser.match(/webOS/i)
            || whatUser.match(/Ipad/i)
            || whatUser.match(/Ipod/i)
            || whatUser.match(/BlackBerry/i)
            || whatUser.match(/Windows Phone/i)) {
            return true;
        } else {
            return false;
        }
    }

    init(){
        this.openModal();
    }
}