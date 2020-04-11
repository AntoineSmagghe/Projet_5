export default class Flash
{
    constructor(flashElt, animationOut, time = 10)
    {
        this.flashElt = flashElt;
        this.animationOut = animationOut;
        this.time = time * 1000;
    }

    flashing()
    {
        setTimeout(()=>{
            this.flashElt.style.animation = this.animationOut + " 5s ease";
        }, this.time - 5000);

        setTimeout(() => {
            this.flashElt.style.display = "none";
        }, this.time - 200);
    }

    init()
    {
        this.flashing();
    }
}