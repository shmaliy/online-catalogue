var SliderCatalogue = Class.create({
	initialize: function (placeholder, elements)
	{
	    /* options */
	    this.placeholder = $(placeholder);
	    this.elements = elements || ['empty'];
	    this.animate = true;
	    this.duration = 0.75;
	    
	    if (!this.placeholder) {
	    	return false;
	    }
		
		/* html */
	    this.placeholder.update(
			this.eContainer = new Element('div', {'class': 'slider-container'}).insert(
				this.btnSlideLeftPh = new Element('div', {'class': 'slider-larr'})
			).insert(
				new Element('div', {'class': 'slider-width'}).insert(
					this.eContents = new Element('div', {'class': 'slider-contents'})
				)
			).insert(
				this.btnSlideRightPh = new Element('div', {'class': 'slider-rarr'})
			).insert(
				new Element('div', {'class': 'clr'})
			)
		);
		
		for (var i = 0; i < this.elements.length; i++) {
			this.eContents.insert(
				new Element('div', {'class': 'slider-contents-item'}).insert(this.elements[i])
			);
		}
		
		var width = (this.eContents.getWidth() * this.elements.length);
		this.width = this.eContents.getWidth();
		this.eContents.setStyle('width:' + width + 'px');

		if (this.elements.length > 0) {
			this.btnSlideLeftPh.insert(
				this.btnSlideLeft = new Element('a', {'href': '#'})
			);
			this.btnSlideRightPh.insert(
				this.btnSlideRight = new Element('a', {'href': '#'})
			);
			this.observer();
		}
		
		this.current = 0;
	},
	observer: function()
	{
		this.eventSlideLeft = this.slideLeft.bindAsEventListener(this);
		this.eventSlideRight = this.slideRight.bindAsEventListener(this);
		this.btnSlideLeft.observe("click", this.eventSlideLeft);
		this.btnSlideRight.observe("click", this.eventSlideRight);
	},
	deobserver: function()
	{
		if (this.eventSlideLeft) {
			Event.stopObserving(this.btnSlideLeft, "click", this.eventSlideLeft);
		}
		
		if (this.eventSlideRight) {
			Event.stopObserving(this.btnSlideRight, "click", this.eventSlideRight);
		}
	},
	slideLeft: function(event)
	{
		event.stop();
		if (this.current < this.elements.length - 1) {
			var offset = (this.current + 1) * this.width;
			if (this.animate) {
				this.deobserver();
				this.effect = new Effect.Morph(this.eContents, {
					style: 'margin-left: -' + offset + 'px;',
					duration: this.duration,
					afterFinish: (function(){
						this.current++;
						this.observer();
					}).bind(this)
				});
			} else {
				this.deobserver();
				this.eContents.setStyle('margin-left: -' + offset + 'px;');
				this.observer();
			}
		}
		
		return false;
	},
	slideRight: function(event)
	{
		event.stop();		
		if (this.current > 0) {
			var offset = (this.current - 1) * this.width;
			if (this.animate) {
				this.deobserver();
				this.effect = new Effect.Morph(this.eContents, {
					style: 'margin-left: -' + offset + 'px;',
					duration: this.duration,
					afterFinish: (function(){
						this.current--;
						this.observer();
					}).bind(this)
				});
			} else {
				this.deobserver();
				this.eContents.setStyle('margin-left: -' + offset + 'px;');
				this.observer();
			}
		}
		
		return false;
	}
});
