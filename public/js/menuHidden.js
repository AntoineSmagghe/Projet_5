/**
 *  Listen an icon and open a menu.
 * idListen = target to the icon.
 * idToShow = target to the dropdown content.
 * howToDisplay = is the display css style. like flex or block.
 * animIn = animation when user click on it.
 * animOut = animation when user get out of the submenu.
 * hideIco = boolean, icone must be hide?
 * 
 * @class menuHidden
 */

class menuHidden{
    constructor(idListen, idToShow, howToDisplay, animIn, animOut, hideIco = true){
        this.idListen = idListen;
        this.idToShow = idToShow;
        this.howToDisplay = howToDisplay;
        this.animIn = animIn;
        this.animOut = animOut;
        this.menuIsOpen = false;
        this.hideIco = hideIco;
    }

    listenIco(){
        this.idListen.addEventListener("mouseenter", ()=>{
            if (this.hideIco){
                this.idListen.style.opacity = "0";
            }
            this.idListen.style.animation = "";
            this.idToShow.style.position = "absolute";
            this.idToShow.style.display = this.howToDisplay;
            this.idToShow.style.animation = this.animIn + ".5s";
            this.menuIsOpen = true;
            this.closeMenu();
        });
    }
    
    closeMenu(){
        this.idToShow.addEventListener("mouseleave", ()=>{
            if (this.hideIco){
                this.idListen.style.opacity = "1";
            }
            this.idToShow.style.display = "none";
            this.idListen.style.animation = this.animOut + ".5s";
        });
        
        if (this.isMobile()){
            window.addEventListener("scroll", ()=>{
                if (this.hideIco){
                    this.idListen.style.opacity = "1";
                }
                this.idToShow.style.display = "none";
                this.idListen.style.animation = this.animOut + ".5s";
            });
        }
    }

    hideMenuWhenScroll(listenEvent){
        window.removeEventListener(listenEvent, this.hideMenuWhenScroll);
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
}