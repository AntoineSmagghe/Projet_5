/**
 * Moving elts in the DOM with media screen width
 */

class MovingElt
{
    constructor(eltToMove, where, maxScreenSize)
    {
        this.eltToMove = eltToMove;
        this.where = where;
        this.maxScreenSize = maxScreenSize;
    }

    resize()
    {
        if (window.innerWidth < this.maxScreenSize){
            this.where.appendChild(this.eltToMove);
        }
    }

    init()
    {
        this.resize();
    }
}