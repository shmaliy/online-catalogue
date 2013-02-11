/* Крутилка нового в каталоге */

var ImageSwapper = Class.create({
	timer: null,
	initialize: function ()
	{
	    this.images = $("top_image").select('img');
	    this.active = 0;
	    this.setTimer();
	},
	swap: function()
	{
		this.active++;
		
		if (this.active == this.images.length) {
			this.active = 0;
		}
		
		for (var i = 0; i < this.images.length; i++) {
			if (this.active != i) {
				this.images[i].setStyle({zIndex:5});
			}
		}
		
		this.images[this.active].setStyle({zIndex:10});
		new Effect.Appear(this.images[this.active], {
			duration: 2,
			afterFinish: (function(){
				for (var i = 0; i < this.images.length; i++) {
					if (this.active != i) {
						this.images[i].hide();
					}
				}
				this.setTimer();
			}).bind(this)
		});
	},
	setTimer: function()
	{
		this.timer = setTimeout((function(){
			this.swap();
		}).bind(this), 10000);
	}
});