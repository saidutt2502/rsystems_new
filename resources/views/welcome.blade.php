<style>

canvas {
  display: block;
  vertical-align: bottom;
}

#particles-js {
  position: absolute;
  width: 100%;
  height: 100%;
	background: #00356B;
}

.text {
	position: absolute;
	top: 50%;
	right: 50%;
	transform: translate(50%,-50%);
	color: #fff;
	max-width: 90%;
	padding: 2em 3em;
	background: rgba(0, 0, 0, 0.4);
	text-shadow: 0px 0px 2px #131415;
	font-family: 'Open Sans', sans-serif;
}

h1 {
	font-size: 2.25em;
	font-weight: 700;
	letter-spacing: -1px;
}

a,
a:visited {
	transition: 0.25s;
}


.button {
    background-color: #555555;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    border-radius: 8px;

    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
}

</style>

<style>
/* ---- reset ---- */ body{ margin:0; font:normal 75% Arial, Helvetica, sans-serif; } canvas{ display: block; vertical-align: bottom; } /* ---- particles.js container ---- */ #particles-js{ position:absolute; width: 100%; height: 100%; background-color: #00356B; background-image: url(""); background-repeat: no-repeat; background-size: cover; background-position: 50% 50%; } /* ---- stats.js ---- */ .count-particles{ background: #000022; position: absolute; top: 48px; left: 0; width: 80px; color: #13E8E9; font-size: .8em; text-align: left; text-indent: 4px; line-height: 14px; padding-bottom: 2px; font-family: Helvetica, Arial, sans-serif; font-weight: bold; } .js-count-particles{ font-size: 1.1em; } #stats, .count-particles{ -webkit-user-select: none; margin-top: 5px; margin-left: 5px; } #stats{ border-radius: 3px 3px 0 0; overflow: hidden; } .count-particles{ border-radius: 0 0 3px 3px; }
</style>

<script src="/core/js/jquery-2.1.4.min.js"></script>


<body>


<!-- particles.js container --> <div id="particles-js"></div>

<div class="text">
    <div class="typing-animation" style="font-size: 50px;text-align: center;color: #f9f9f9;">
    <span id="quote"></span>
    </div>
    <br><br>
   <center> <a class="button" href="/login">Login here</a></center>
</div>


</div> <!-- stats - count particles --> <!-- particles.js lib - https://github.com/VincentGarreau/particles.js --> <script src="http://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script> 




</body>


<script>



particlesJS("particles-js", {
  "particles": {
    "number": {
      "value": 80,
      "density": {
        "enable": true,
        "value_area": 700
      }
    },
    "color": {
      "value": "#ffffff"
    },
    "shape": {
      "type": "circle",
      "stroke": {
        "width": 0,
        "color": "#000000"
      },
      "polygon": {
        "nb_sides": 5
      },
    },
    "opacity": {
      "value": 0.5,
      "random": false,
      "anim": {
        "enable": false,
        "speed": 1,
        "opacity_min": 0.1,
        "sync": false
      }
    },
    "size": {
      "value": 3,
      "random": true,
      "anim": {
        "enable": false,
        "speed": 40,
        "size_min": 0.1,
        "sync": false
      }
    },
    "line_linked": {
      "enable": true,
      "distance": 150,
      "color": "#ffffff",
      "opacity": 0.4,
      "width": 1
    },
    "move": {
      "enable": true,
      "speed": 6,
      "direction": "none",
      "random": false,
      "straight": false,
      "out_mode": "out",
      "bounce": false,
      "attract": {
        "enable": false,
        "rotateX": 600,
        "rotateY": 1200
      }
    }
  },
  "interactivity": {
    "detect_on": "canvas",
    "events": {
      "onhover": {
        "enable": true,
        "mode": "grab"
      },
      "onclick": {
        "enable": true,
        "mode": "push"
      },
      "resize": true
    },
    "modes": {
      "grab": {
        "distance": 140,
        "line_linked": {
          "opacity": 1
        }
      },
      "bubble": {
        "distance": 400,
        "size": 40,
        "duration": 2,
        "opacity": 8,
        "speed": 3
      },
      "repulse": {
        "distance": 200,
        "duration": 0.4
      },
      "push": {
        "particles_nb": 4
      },
      "remove": {
        "particles_nb": 2
      }
    }
  },
  "retina_detect": true
});

// The MIT License (MIT)

// Typed.js | Copyright (c) 2014 Matt Boldt | www.mattboldt.com

// Permission is hereby granted, free of charge, to any person obtaining a copy
// of this software and associated documentation files (the "Software"), to deal
// in the Software without restriction, including without limitation the rights
// to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
// copies of the Software, and to permit persons to whom the Software is
// furnished to do so, subject to the following conditions:

// The above copyright notice and this permission notice shall be included in
// all copies or substantial portions of the Software.

// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
// OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
// THE SOFTWARE.




! function($) {

"use strict";

var Typed = function(el, options) {

    // chosen element to manipulate text
    this.el = $(el);

    // options
    this.options = $.extend({}, $.fn.typed.defaults, options);

    // attribute to type into
    this.isInput = this.el.is('input');
    this.attr = this.options.attr;

    // show cursor
    this.showCursor = this.isInput ? false : this.options.showCursor;

    // text content of element
    this.elContent = this.attr ? this.el.attr(this.attr) : this.el.text()

    // html or plain text
    this.contentType = this.options.contentType;

    // typing speed
    this.typeSpeed = this.options.typeSpeed;

    // add a delay before typing starts
    this.startDelay = this.options.startDelay;

    // backspacing speed
    this.backSpeed = this.options.backSpeed;

    // amount of time to wait before backspacing
    this.backDelay = this.options.backDelay;

    // div containing strings
    this.stringsElement = this.options.stringsElement;

    // input strings of text
    this.strings = this.options.strings;

    // character number position of current string
    this.strPos = 0;

    // current array position
    this.arrayPos = 0;

    // number to stop backspacing on.
    // default 0, can change depending on how many chars
    // you want to remove at the time
    this.stopNum = 0;

    // Looping logic
    this.loop = this.options.loop;
    this.loopCount = this.options.loopCount;
    this.curLoop = 0;

    // for stopping
    this.stop = false;

    // custom cursor
    this.cursorChar = this.options.cursorChar;

    // shuffle the strings
    this.shuffle = this.options.shuffle;
    // the order of strings
    this.sequence = [];

    // All systems go!
    this.build();
};

Typed.prototype = {

    constructor: Typed

    ,
    init: function() {
        // begin the loop w/ first current string (global self.strings)
        // current string will be passed as an argument each time after this
        var self = this;
        self.timeout = setTimeout(function() {
            for (var i=0;i<self.strings.length;++i) self.sequence[i]=i;

            // shuffle the array if true
            if(self.shuffle) self.sequence = self.shuffleArray(self.sequence);

            // Start typing
            self.typewrite(self.strings[self.sequence[self.arrayPos]], self.strPos);
        }, self.startDelay);
    }

    ,
    build: function() {
        var self = this;
        // Insert cursor
        if (this.showCursor === true) {
            this.cursor = $("<span class=\"typed-cursor\">" + this.cursorChar + "</span>");
            this.el.after(this.cursor);
        }
        if (this.stringsElement) {
            self.strings = [];
            this.stringsElement.hide();
            var strings = this.stringsElement.find('p');
            $.each(strings, function(key, value){
                self.strings.push($(value).html());
            });
        }
        this.init();
    }

    // pass current string state to each function, types 1 char per call
    ,
    typewrite: function(curString, curStrPos) {
        // exit when stopped
        if (this.stop === true) {
            return;
        }

        // varying values for setTimeout during typing
        // can't be global since number changes each time loop is executed
        var humanize = Math.round(Math.random() * (100 - 30)) + this.typeSpeed;
        var self = this;

        // ------------- optional ------------- //
        // backpaces a certain string faster
        // ------------------------------------ //
        // if (self.arrayPos == 1){
        //  self.backDelay = 50;
        // }
        // else{ self.backDelay = 500; }

        // contain typing function in a timeout humanize'd delay
        self.timeout = setTimeout(function() {
            // check for an escape character before a pause value
            // format: \^\d+ .. eg: ^1000 .. should be able to print the ^ too using ^^
            // single ^ are removed from string
            var charPause = 0;
            var substr = curString.substr(curStrPos);
            if (substr.charAt(0) === '^') {
                var skip = 1; // skip atleast 1
                if (/^\^\d+/.test(substr)) {
                    substr = /\d+/.exec(substr)[0];
                    skip += substr.length;
                    charPause = parseInt(substr);
                }

                // strip out the escape character and pause value so they're not printed
                curString = curString.substring(0, curStrPos) + curString.substring(curStrPos + skip);
            }

            if (self.contentType === 'html') {
                // skip over html tags while typing
                var curChar = curString.substr(curStrPos).charAt(0)
                if (curChar === '<' || curChar === '&') {
                    var tag = '';
                    var endTag = '';
                    if (curChar === '<') {
                        endTag = '>'
                    } else {
                        endTag = ';'
                    }
                    while (curString.substr(curStrPos).charAt(0) !== endTag) {
                        tag += curString.substr(curStrPos).charAt(0);
                        curStrPos++;
                    }
                    curStrPos++;
                    tag += endTag;
                }
            }

            // timeout for any pause after a character
            self.timeout = setTimeout(function() {
                if (curStrPos === curString.length) {
                    // fires callback function
                    self.options.onStringTyped(self.arrayPos);

                    // is this the final string
                    if (self.arrayPos === self.strings.length - 1) {
                        // animation that occurs on the last typed string
                        self.options.callback();

                        self.curLoop++;

                        // quit if we wont loop back
                        if (self.loop === false || self.curLoop === self.loopCount)
                            return;
                    }

                    self.timeout = setTimeout(function() {
                        self.backspace(curString, curStrPos);
                    }, self.backDelay);
                } else {

                    /* call before functions if applicable */
                    if (curStrPos === 0)
                        self.options.preStringTyped(self.arrayPos);

                    // start typing each new char into existing string
                    // curString: arg, self.el.html: original text inside element
                    var nextString = curString.substr(0, curStrPos + 1);
                    if (self.attr) {
                        self.el.attr(self.attr, nextString);
                    } else {
                        if (self.isInput) {
                            self.el.val(nextString);
                        } else if (self.contentType === 'html') {
                            self.el.html(nextString);
                        } else {
                            self.el.text(nextString);
                        }
                    }

                    // add characters one by one
                    curStrPos++;
                    // loop the function
                    self.typewrite(curString, curStrPos);
                }
                // end of character pause
            }, charPause);

            // humanized value for typing
        }, humanize);

    }

    ,
    backspace: function(curString, curStrPos) {
        // exit when stopped
        if (this.stop === true) {
            return;
        }

        // varying values for setTimeout during typing
        // can't be global since number changes each time loop is executed
        var humanize = Math.round(Math.random() * (100 - 30)) + this.backSpeed;
        var self = this;

        self.timeout = setTimeout(function() {

            // ----- this part is optional ----- //
            // check string array position
            // on the first string, only delete one word
            // the stopNum actually represents the amount of chars to
            // keep in the current string. In my case it's 14.
            // if (self.arrayPos == 1){
            //  self.stopNum = 14;
            // }
            //every other time, delete the whole typed string
            // else{
            //  self.stopNum = 0;
            // }

            if (self.contentType === 'html') {
                // skip over html tags while backspacing
                if (curString.substr(curStrPos).charAt(0) === '>') {
                    var tag = '';
                    while (curString.substr(curStrPos).charAt(0) !== '<') {
                        tag -= curString.substr(curStrPos).charAt(0);
                        curStrPos--;
                    }
                    curStrPos--;
                    tag += '<';
                }
            }

            // ----- continue important stuff ----- //
            // replace text with base text + typed characters
            var nextString = curString.substr(0, curStrPos);
            if (self.attr) {
                self.el.attr(self.attr, nextString);
            } else {
                if (self.isInput) {
                    self.el.val(nextString);
                } else if (self.contentType === 'html') {
                    self.el.html(nextString);
                } else {
                    self.el.text(nextString);
                }
            }

            // if the number (id of character in current string) is
            // less than the stop number, keep going
            if (curStrPos > self.stopNum) {
                // subtract characters one by one
                curStrPos--;
                // loop the function
                self.backspace(curString, curStrPos);
            }
            // if the stop number has been reached, increase
            // array position to next string
            else if (curStrPos <= self.stopNum) {
                self.arrayPos++;

                if (self.arrayPos === self.strings.length) {
                    self.arrayPos = 0;

                    // Shuffle sequence again
                    if(self.shuffle) self.sequence = self.shuffleArray(self.sequence);

                    self.init();
                } else
                    self.typewrite(self.strings[self.sequence[self.arrayPos]], curStrPos);
            }

            // humanized value for typing
        }, humanize);

    }
    /**
     * Shuffles the numbers in the given array.
     * @param {Array} array
     * @returns {Array}
     */
    ,shuffleArray: function(array) {
        var tmp, current, top = array.length;
        if(top) while(--top) {
            current = Math.floor(Math.random() * (top + 1));
            tmp = array[current];
            array[current] = array[top];
            array[top] = tmp;
        }
        return array;
    }

    // Start & Stop currently not working

    // , stop: function() {
    //     var self = this;

    //     self.stop = true;
    //     clearInterval(self.timeout);
    // }

    // , start: function() {
    //     var self = this;
    //     if(self.stop === false)
    //        return;

    //     this.stop = false;
    //     this.init();
    // }

    // Reset and rebuild the element
    ,
    reset: function() {
        var self = this;
        clearInterval(self.timeout);
        var id = this.el.attr('id');
        this.el.after('<span id="' + id + '"/>')
        this.el.remove();
        if (typeof this.cursor !== 'undefined') {
            this.cursor.remove();
        }
        // Send the callback
        self.options.resetCallback();
    }

};

$.fn.typed = function(option) {
    return this.each(function() {
        var $this = $(this),
            data = $this.data('typed'),
            options = typeof option == 'object' && option;
        if (!data) $this.data('typed', (data = new Typed(this, options)));
        if (typeof option == 'string') data[option]();
    });
};

$.fn.typed.defaults = {
    strings: ["These are the default values...", "You know what you should do?", "Use your own!", "Have a great day!"],
    stringsElement: null,
    // typing speed
    typeSpeed: 0,
    // time before typing starts
    startDelay: 0,
    // backspacing speed
    backSpeed: 0,
    // shuffle the strings
    shuffle: false,
    // time before backspacing
    backDelay: 500,
    // loop
    loop: false,
    // false = infinite
    loopCount: false,
    // show cursor
    showCursor: true,
    // character for cursor
    cursorChar: "<span class='cursor'>|</span>",
    // attribute to type (null == text)
    attr: null,
    // either html or text
    contentType: 'html',
    // call when done callback function
    callback: function() {},
    // starting callback function before each string
    preStringTyped: function() {},
    //callback for every typed string
    onStringTyped: function() {},
    // callback for reset
    resetCallback: function() {}
};


}(window.jQuery);

/*
* rwdImageMaps jQuery plugin v1.5
*
* Allows image maps to be used in a responsive design by recalculating the area coordinates to match the actual image size on load and window.resize
*
* Copyright (c) 2013 Matt Stow
* https://github.com/stowball/jQuery-rwdImageMaps
* http://mattstow.com
* Licensed under the MIT license
*/
;(function(a){a.fn.rwdImageMaps=function(){var c=this;var b=function(){c.each(function(){if(typeof(a(this).attr("usemap"))=="undefined"){return}var e=this,d=a(e);a("<img />").load(function(){var g="width",m="height",n=d.attr(g),j=d.attr(m);if(!n||!j){var o=new Image();o.src=d.attr("src");if(!n){n=o.width}if(!j){j=o.height}}var f=d.width()/100,k=d.height()/100,i=d.attr("usemap").replace("#",""),l="coords";a('map[name="'+i+'"]').find("area").each(function(){var r=a(this);if(!r.data(l)){r.data(l,r.attr(l))}var q=r.data(l).split(","),p=new Array(q.length);for(var h=0;h<p.length;++h){if(h%2===0){p[h]=parseInt(((q[h]/n)*100)*f)}else{p[h]=parseInt(((q[h]/j)*100)*k)}}r.attr(l,p.toString())})}).attr("src",d.attr("src"))})};a(window).resize(b).trigger("resize");return this}})(jQuery);


$(function(){
  $("#quote").typed({
    strings: ["Rsystems<br/>Rosenberger | India"],
    typeSpeed: 200,
    backSpeed: 0,
    loop: true
  });
});
</script>


