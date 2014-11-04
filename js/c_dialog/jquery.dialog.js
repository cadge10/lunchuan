var c_dialog = {
    init: function(isladding){/*锁定窗口时不显示loading图片，如参数为ture显示*/
        if($.browser.msie && $.browser.version=='6.0'){$("select").css("visibility", "hidden");} // isIE6 = !-[1,] && !window.XMLHttpRequest // return true or false
		if(isladding){
        var a = '<div id="c_dialog_overlay"></div><div id="c_dialog_window"><a id="c_dialog_close" href="#" title="\u5173\u95ed"></a><div id="c_dialog_title">\u8bf7\u7a0d\u5019...</div><div id="c_dialog_body"></div></div>';
        }else{//默认锁定窗口时显示loading图片
        var a = '<div id="c_dialog_overlay"></div><div id="c_dialog_loading"></div><div id="c_dialog_window"><a id="c_dialog_close" href="#" title="\u5173\u95ed"></a><div id="c_dialog_title">\u8bf7\u7a0d\u5019...</div><div id="c_dialog_body"></div></div>';
		}
	   $("body").append(a);
        var b = this.closeFun ? this.closeFun : function(){
        };
        $("#c_dialog_close").click(function(){
            b();
            c_dialog.close();
            return false
        });
        $("#c_dialog_overlay").show();
        $("#c_dialog_loading").show();
        this.position();
        return this
    },
    openHtml: function(b, e, a, d, c, f){
		/*
		 (
		    b:html,
			e:title,
			a:width,
			d:height,
			c:callback,
			f:closeFun
		  )
		*/
        if (f && $.isFunction(f.closeFun)) {
            this.closeFun = f.closeFun
        }
        this.init();
        if (b != undefined) {
        	if (typeof b=='object'){
        		$("#c_dialog_body").append(b.children());
        		this.close_fun2 = function () {
						b.append( $("#c_dialog_body").children() ); // move elements back when you're finished
				};
        	}else {
            	$("#c_dialog_body").html(b)
            }
        }
        this.title(e == undefined ? "\u540C\u5B66" : e);
        this.resize(a ? a : 300, d ? d : 150);
        $("#c_dialog_loading").remove();
        $("#c_dialog_window").show();
        if ($.isFunction(c)) {
            c()
        }
        return this
    },
    openUrl: function(c, g, a, e, scrolling){
		/*
		(
		   c:url,
		   g:title,
		   a:width,
		   e:height,
		   scrolling:scroll
		 )
		*/
        this.init();
        var b = a != undefined ? a : 300;
        var f = e != undefined ? e : 150;
		var s = scrolling != undefined ? scrolling : 'no';
        var d = (new Date).getTime();
        if (c.indexOf("?") == -1) {
            c = c + "?_t=" + d
        }
        else {
            c = c + "&_t=" + d
        }
        this.title(g == undefined ? "\u540C\u5B66" : g);
        $("#c_dialog_body").html('<iframe id="c_dialog_iframe" scrolling="'+s+'" frameborder="0"></iframe>');
        $("#c_dialog_iframe").attr("src", c);
        this.resize(b, f);
        $("#c_dialog_loading").remove();
        $("#c_dialog_window").show()
    },
    close: function(){
    	if (typeof this.close_fun2=='function'){
    		this.close_fun2();
    	}
        $("#c_dialog_window").remove();
        $("#c_dialog_overlay").remove();
        if($.browser.msie && $.browser.version=='6.0'){$("select").css("visibility", "visible");}
        return this
    },
    resize: function(a, c){//(a:width---int, b:height----int)
        var d = a ? a : 300;
        var b = c ? c : 150;
        $("#c_dialog_window").css({
            width: d + "px",
            height: b + "px"
        });
        $("#c_dialog_body").css("height", "99%").css("height", c - 28 + "px");
        this.position();
        return this
    },
    position: function(){
        var b = $("#c_dialog_window").width();
        var a = $("#c_dialog_window").height();
        $("#c_dialog_window").css({
            marginLeft: "-" + parseInt(b / 2) + "px"
        });
        if (!($.browser.msie && $.browser.version < 7)) {
            $("#c_dialog_window").css({
                marginTop: "-" + parseInt(a / 2) + "px"
            })
        }
        return this
    },
    title: function(a){
        if (a != undefined) {
            $("#c_dialog_title").text(a);
            return this
        }
        else {
            return $("#c_dialog_title").text()
        }
    }
};
// 提示框  ico 1正确，2错误
var c_tips = {
    Counter: 0,
    open: function(e, d, c, b){//(e:html,d:timer,c:type(int),b:callback)
        $('.c_tips_window').remove();
        var jstz = e.indexOf('<script');
        if (jstz!=-1) {
            e='正在载入中...'+e;
        }
		if (c == undefined || c < 1 || c > 2) c = 2;
        if($.browser.msie && $.browser.version=='6.0'){$("select").css("visibility", "hidden");}
        this.Counter++;
        var a = '<div id="c_tips_' + this.Counter + '" class="c_tips_window"><div class="c_tips_wrap">' + e + "</div></div>";
        $("body").append(a);
        $("#c_tips_" + this.Counter + " > .c_tips_wrap").addClass("c_tips_ico_" + c);
        this.position(this.Counter);
        if (typeof b == "function") {
            b()
        }
        if (d != undefined && d != 0) {
            $("#c_tips_" + this.Counter + " > .c_tips_wrap").append('<div class="c_tips_autoclose">('+d+"秒后关闭)</div>");
            setTimeout('$("#c_tips_' + this.Counter + '").remove();if($.browser.msie && $.browser.version=="6.0"){$("select").css("visibility", "visible");}', d * 1000)
        }
    },
    position: function(c){//(c:this.Counter)
        var b = $("#c_tips_" + c).width();
        var a = $("#c_tips_" + c).height();
        $("#c_tips_" + c).css({
            marginLeft: "-" + parseInt(b / 2) + "px"
        })
    }
};