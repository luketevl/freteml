/*!
 * jQuery Upload File Plugin
 * version: 3.1.7
 * @requires jQuery v1.5 or later & form plugin
 * Copyright (c) 2013 Ravishanker Kusuma
 * http://hayageek.com/
 */
(function(e) {
	if (e.fn.ajaxForm == undefined) {
		e.getScript("http://malsup.github.io/jquery.form.js")
	}
	var t = {};
	t.fileapi = e("<input type='file'/>").get(0).files !== undefined;
	t.formdata = window.FormData !== undefined;
	e.fn.uploadFile = function(n) {
		function a() {
			if (r.afterUploadAll && !u) {
				u = true;
				(function e() {
					if (s.sCounter != 0
							&& s.sCounter + s.fCounter == s.tCounter) {
						r.afterUploadAll(s);
						u = false
					} else
						window.setTimeout(e, 100)
				})()
			}
		}
		function f(t, n, r) {
			r.on("dragenter", function(t) {
				t.stopPropagation();
				t.preventDefault();
				e(this).css("border", "2px solid #A5A5C7")
			});
			r.on("dragover", function(e) {
				e.stopPropagation();
				e.preventDefault()
			});
			r.on("drop", function(r) {
				e(this).css("border", "2px dotted #A5A5C7");
				r.preventDefault();
				t.errorLog.html("");
				var i = r.originalEvent.dataTransfer.files;
				if (!n.multiple && i.length > 1) {
					if (n.showError)
						e(
								"<div style='color:red;'>"
										+ n.multiDragErrorStr + "</div>")
								.appendTo(t.errorLog);
					return
				}
				if (n.onSelect(i) == false)
					return;
				h(n, t, i)
			});
			e(document).on("dragenter", function(e) {
				e.stopPropagation();
				e.preventDefault()
			});
			e(document).on("dragover", function(e) {
				e.stopPropagation();
				e.preventDefault();
				r.css("border", "2px dotted #A5A5C7")
			});
			e(document).on("drop", function(e) {
				e.stopPropagation();
				e.preventDefault();
				r.css("border", "2px dotted #A5A5C7")
			})
		}
		function l(e) {
			var t = "";
			var n = e / 1024;
			if (parseInt(n) > 1024) {
				var r = n / 1024;
				t = r.toFixed(2) + " MB"
			} else {
				t = n.toFixed(2) + " KB"
			}
			return t
		}
		function c(t) {
			var n = [];
			if (jQuery.type(t) == "string") {
				n = t.split("&")
			} else {
				n = e.param(t).split("&")
			}
			var r = n.length;
			var i = [];
			var s, o;
			for (s = 0; s < r; s++) {
				n[s] = n[s].replace(/\+/g, " ");
				o = n[s].split("=");
				i.push([ decodeURIComponent(o[0]), decodeURIComponent(o[1]) ])
			}
			return i
		}
		function h(t, n, r) {
			for ( var i = 0; i < r.length; i++) {
				if (!p(n, t, r[i].name)) {
					if (t.showError)
						/*e(

								"<div style='color:red;'><b>" + r[i].name
										+ "</b> " + t.extErrorStr
										+ t.allowedTypes + "</div>").appendTo(
								n.errorLog); */
							msg =  r[i].name + t.extErrorStr + t.allowedTypes;
							var n = noty({text: msg, type: 'error'});
					continue
				}
				if (t.maxFileSize != -1 && r[i].size > t.maxFileSize) {
					if (t.showError)
					/*	e(
								"<div style='color:red;'><b>" + r[i].name
										+ "</b> " + t.sizeErrorStr
										+ l(t.maxFileSize) + "</div>")
								.appendTo(n.errorLog); */
								msg =  r[i].name + t.extErrorStr + t.allowedTypes;
							var n = noty({text: msg, type: 'error'});
					continue
				}
				if (t.maxFileCount != -1 && n.selectedFiles >= t.maxFileCount) {
					if (t.showError)
						/*e(
								"<div style='color:red;'><b>" + r[i].name
										+ "</b> " + t.maxFileCountErrorStr
										+ t.maxFileCount + "</div>").appendTo(
								n.errorLog);
*/
										msg =  r[i].name + t.extErrorStr + t.allowedTypes;
							var n = noty({text: msg, type: 'error'});
					continue
				}
				n.selectedFiles++;
				var s = t;
				var o = new FormData;
				var u = t.fileName.replace("[]", "");
				o.append(u, r[i]);
				var a = t.formData;
				if (a) {
					var f = c(a);
					for ( var h = 0; h < f.length; h++) {
						if (f[h]) {
							o.append(f[h][0], f[h][1])
						}
					}
				}
				s.fileData = o;
				var d = new g(n, t);
				var v = "";
				if (t.showFileCounter)
					v = n.fileCounter + t.fileCounterStyle + r[i].name;
				else
					v = r[i].name;
				d.filename.html(v);
				var m = e("<form style='display:block; position:absolute;left: 150px;' class='"
						+ n.formGroup
						+ "' method='"
						+ t.method
						+ "' action='"
						+ t.url + "' enctype='" + t.enctype + "'></form>");
				m.appendTo("body");
				var b = [];
				b.push(r[i].name);
				y(m, s, d, b, n, r[i]);
				n.fileCounter++
			}
		}
		function p(e, t, n) {
			var r = t.allowedTypes.toLowerCase().split(",");
			var i = n.split(".").pop().toLowerCase();
			if (t.allowedTypes != "*" && jQuery.inArray(i, r) < 0) {
				return false
			}
			return true
		}
		function d(e, t) {
			if (e) {
				t.show();
				var n = new FileReader;
				n.onload = function(e) {
					t.attr("src", e.target.result)
				};
				n.readAsDataURL(e)
			}
		}
		function v(t, n) {
			if (t.showFileCounter) {
				var r = e(".ajax-file-upload-filename").length;
				n.fileCounter = r + 1;
				e(".ajax-file-upload-filename").each(function(n, i) {
					var s = e(this).html().split(t.fileCounterStyle);
					var o = parseInt(s[0]) - 1;
					var u = r + t.fileCounterStyle + s[1];
					e(this).html(u);
					r--
				})
			}
		}
		function m(n, r, i, s) {
			var o = "ajax-upload-id-" + (new Date).getTime();
			var u = e("<form method='" + i.method + "' action='" + i.url
					+ "' enctype='" + i.enctype + "'></form>");
			var a = "<input type='file' id='" + o + "' name='" + i.fileName
					+ "' accept='" + i.acceptFiles + "'/>";
			if (i.multiple) {
				if (i.fileName.indexOf("[]") != i.fileName.length - 2) {
					i.fileName += "[]"
				}
				a = "<input type='file' id='" + o + "' name='" + i.fileName
						+ "' accept='" + i.acceptFiles + "' multiple/>"
			}
			var f = e(a).appendTo(u);
			f.change(function() {
				n.errorLog.html("");
				var o = i.allowedTypes.toLowerCase().split(",");
				var a = [];
				if (this.files) {
					for (b = 0; b < this.files.length; b++) {
						a.push(this.files[b].name)
					}
					if (i.onSelect(this.files) == false)
						return
				} else {
					var f = e(this).val();
					var l = [];
					a.push(f);
					if (!p(n, i, f)) {
						if (i.showError)
							/*e(
									"<div style='color:red;'><b>" + f + "</b> "
											+ i.extErrorStr + i.allowedTypes
											+ "</div>").appendTo(n.errorLog);
						*/
							msg =  r[i].name + t.extErrorStr + t.allowedTypes;
							var n = noty({text: msg, type: 'error'});
						return
					}
					l.push({
						name : f,
						size : "NA"
					});
					if (i.onSelect(l) == false)
						return
				}
				v(i, n);
				s.unbind("click");
				u.hide();
				m(n, r, i, s);
				u.addClass(r);
				if (t.fileapi && t.formdata) {
					u.removeClass(r);
					var c = this.files;
					h(i, n, c)
				} else {
					var d = "";
					for ( var b = 0; b < a.length; b++) {
						if (i.showFileCounter)
							d += n.fileCounter + i.fileCounterStyle + a[b]
									+ "<br>";
						else
							d += a[b] + "<br>";
						n.fileCounter++
					}
					if (i.maxFileCount != -1
							&& n.selectedFiles + a.length > i.maxFileCount) {
						if (i.showError)
							/*e(
									"<div style='color:red;'><b>" + d + "</b> "
											+ i.maxFileCountErrorStr
											+ i.maxFileCount + "</div>")
									.appendTo(n.errorLog);
									*/

									msg =   i.maxFileCountErrorStr + i.maxFileCount;
					var n = noty({text: msg, type: 'error'});
						return
					}
					n.selectedFiles += a.length;
					var w = new g(n, i);
					w.filename.html(d);
					y(u, i, w, a, n, null)
				}
			});
			if (i.nestedForms) {
				u.css({
					margin : 0,
					padding : 0
				});
				s.css({
					position : "relative",
					overflow : "hidden",
					cursor : "default"
				});
				f.css({
					position : "absolute",
					cursor : "pointer",
					top : "0px",
					width : "100%",
					height : "100%",
					left : "0px",
					"z-index" : "100",
					opacity : "0.0",
					filter : "alpha(opacity=0)",
					"-ms-filter" : "alpha(opacity=0)",
					"-khtml-opacity" : "0.0",
					"-moz-opacity" : "0.0"
				});
				u.appendTo(s)
			} else {
				u.appendTo(e("body"));
				u.css({
					margin : 0,
					padding : 0,
					display : "block",
					position : "absolute",
					left : "-250px"
				});
				if (navigator.appVersion.indexOf("MSIE ") != -1) {
					s.attr("for", o)
				} else {
					s.click(function() {
						f.click()
					})
				}
			}
		}
		function g(t, n) {
			this.statusbar = e("<div class='ajax-file-upload-statusbar'></div>")
					.width(n.statusBarWidth);
			this.preview = e("<img class='ajax-file-upload-preview'></img>")
					.width(n.previewWidth).height(n.previewHeight).appendTo(
							this.statusbar).hide();
			this.filename = e("<div class='ajax-file-upload-filename'></div>")
					.appendTo(this.statusbar);
			this.progressDiv = e(
/*
'<div class="progress">
  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
    <span class="sr-only">40% Complete (success)</span>
  </div>'
*/
				"<div class='ajax-file-upload-progress'>"

				)
					.appendTo(this.statusbar).hide();
			this.progressbar = e(
					"<div class='ajax-file-upload-bar " + t.formGroup
							+ "'></div>").appendTo(this.progressDiv);
			this.abort = e(

					/*"<div class='ajax-file-upload-red ajax-file-upload-abort "
							+ t.formGroup + "'>" + n.abortStr + "</div>"
*/
					'<span class="glyphicon glyphicon-stop fake-link"></span>'
							)
					.appendTo(this.filename).hide();
			this.cancel = e(
					
					/*"<div class='ajax-file-upload-red ajax-file-upload-cancel "
							+ t.formGroup + "'>" + n.cancelStr + "</div>"
		*/
			'<span class="glyphicon glyphicon-remove-sign fake-link"></span>'

							)
					.appendTo(this.filename).hide();
			this.done = e(
					
/*
					"<div class='ajax-file-upload-green'>" + n.doneStr
							+ "</div>"*/

							'<span class="glyphicon glyphicon-remove-ok fake-link"></span>'


							).appendTo(this.filename).hide();
			this.download = e(
					/*
					"<div class='ajax-file-upload-green'>" + n.downloadStr
							+ "</div>" */

							'<span class="glyphicon glyphicon-remove-download fake-link"></span>'

							).appendTo(this.filename).hide();
			this.del = e(
					/*
					"<div class='ajax-file-upload-red'>" + n.deletelStr
							+ "</div>"
*/
			'<span class="glyphicon glyphicon-remove-sign fake-link"></span>'
							).appendTo(this.filename).hide();
			if (n.showQueueDiv)
				e("#" + n.showQueueDiv).append(this.statusbar);
			else
				t.errorLog.after(this.statusbar);
			return this
		}
		function y(n, r, i, s, o, u) {
			var f = null;
			var l = {
				cache : false,
				contentType : false,
				processData : false,
				forceSync : false,
				type : r.method,
				data : r.formData,
				formData : r.fileData,
				dataType : r.returnType,
				beforeSubmit : function(e, t, u) {
					if (r.onSubmit.call(this, s) != false) {
						var f = r.dynamicFormData();
						if (f) {
							var l = c(f);
							if (l) {
								for ( var h = 0; h < l.length; h++) {
									if (l[h]) {
										if (r.fileData != undefined)
											u.formData.append(l[h][0], l[h][1]);
										else
											u.data[l[h][0]] = l[h][1]
									}
								}
							}
						}
						o.tCounter += s.length;
						a();
						return true
					}
					/*
					i.statusbar.append("<div style='color:red;'>"
							+ r.uploadErrorStr + "</div>");
*/
					msg =   r.uploadErrorSt;
					var n = noty({text: msg, type: 'error'});
					i.cancel.show();
					n.remove();
					i.cancel.click(function() {
						i.statusbar.remove();
						r.onCancel.call(o, s, i);
						o.selectedFiles -= s.length;
						v(r, o)
					});
					return false
				},
				beforeSend : function(e, n) {
					i.progressDiv.show();
					i.cancel.hide();
					i.done.hide();
					if (r.showAbort) {
						i.abort.show();
						i.abort.click(function() {
							e.abort();
							o.selectedFiles -= s.length
						})
					}
					if (!t.formdata) {
						i.progressbar.width("5%")
					} else
						i.progressbar.width("1%")
				},
				uploadProgress : function(e, t, n, s) {
					if (s > 98)
						s = 98;
					var o = s + "%";
					if (s > 1)
						i.progressbar.width(o);
					if (r.showProgress) {
						i.progressbar.html(o);
						i.progressbar.css("text-align", "center")
					}
				},
				success : function(t, u, a) {
					if (r.returnType == "json" && e.type(t) == "object"
							&& t.hasOwnProperty(r.customErrorKeyStr)) {
						i.abort.hide();
						var f = t[r.customErrorKeyStr];
						r.onError.call(this, s, 200, f, i);
						if (r.showStatusAfterError) {
							i.progressDiv.hide();
							i.statusbar
									.append("<span style='color:red;'>ERROR: "
											+ f + "</span>")
						} else {
							i.statusbar.hide();
							i.statusbar.remove()
						}
						o.selectedFiles -= s.length;
						n.remove();
						o.fCounter += s.length;
						return
					}
					o.responses.push(t);
					i.progressbar.width("100%");
					if (r.showProgress) {
						i.progressbar.html("100%");
						i.progressbar.css("text-align", "center")
					}
					i.abort.hide();
					r.onSuccess.call(this, s, t, a, i);
					if (r.showStatusAfterSuccess) {
						if (r.showDone) {
							i.done.show();
							i.done.click(function() {
								i.statusbar.hide("slow");
								i.statusbar.remove()
							})
						} else {
							i.done.hide()
						}
						if (r.showDelete) {
							i.del.show();
							i.del.click(function() {
								i.statusbar.hide().remove();
								if (r.deleteCallback)
									r.deleteCallback.call(this, t, i);
								o.selectedFiles -= s.length;
								v(r, o)
							})
						} else {
							i.del.hide()
						}
					} else {
						i.statusbar.hide("slow");
						i.statusbar.remove()
					}
					if (r.showDownload) {
						i.download.show();
						i.download.click(function() {
							if (r.downloadCallback)
								r.downloadCallback(t)
						})
					}
					n.remove();
					o.sCounter += s.length
				},
				error : function(e, t, u) {
					i.abort.hide();
					if (e.statusText == "abort") {
						i.statusbar.hide("slow").remove();
						v(r, o)
					} else {
						r.onError.call(this, s, t, u, i);
						if (r.showStatusAfterError) {
							i.progressDiv.hide();
							i.statusbar
									.append("<span style='color:red;'>ERROR: "
											+ u + "</span>")
						} else {
							i.statusbar.hide();
							i.statusbar.remove()
						}
						o.selectedFiles -= s.length
					}
					n.remove();
					o.fCounter += s.length
				}
			};
			if (r.showPreview && u != null) {
				if (u.type.toLowerCase().split("/").shift() == "image")
					d(u, i.preview)
			}
			if (r.autoSubmit) {
				n.ajaxSubmit(l)
			} else {
				if (r.showCancel) {
					i.cancel.show();
					i.cancel.click(function() {
						n.remove();
						i.statusbar.remove();
						r.onCancel.call(o, s, i);
						o.selectedFiles -= s.length;
						v(r, o)
					})
				}
				n.ajaxForm(l)
			}
		}
		var r = e
				.extend(
						{
							url : "",
							method : "POST",
							enctype : "multipart/form-data",
							formData : null,
							returnType : null,
							allowedTypes : "*",
							acceptFiles : "*",
							fileName : "file",
							formData : {},
							dynamicFormData : function() {
								return {}
							},
							maxFileSize : -1,
							maxFileCount : -1,
							multiple : true,
							dragDrop : true,
							autoSubmit : true,
							showCancel : true,
							showAbort : true,
							showDone : true,
							showDelete : false,
							showError : true,
							showStatusAfterSuccess : true,
							showStatusAfterError : true,
							showFileCounter : true,
							fileCounterStyle : "). ",
							showProgress : false,
							nestedForms : true,
							showDownload : false,
							onLoad : function(e) {
							},
							onSelect : function(e) {
								return true
							},
							onSubmit : function(e, t) {
							},
							onSuccess : function(e, t, n, r) {
							},
							onError : function(e, t, n, r) {
							},
							onCancel : function(e, t) {
							},
							downloadCallback : false,
							deleteCallback : false,
							afterUploadAll : false,
							uploadButtonClass : "ajax-file-upload",
							dragDropStr : "<span> <b>ou</b> Arraste e solte</span>",
							abortStr : "Abortar",
							cancelStr : "Cancelar",
							deletelStr : "Apagar",
							doneStr : "Concluído",
							multiDragErrorStr : "Não é permitido arrastar e soltar.",
							extErrorStr : "não é permitido. Extensões permitidas: ",
							sizeErrorStr : "não é permitido. Tamanho máximo: ",
							uploadErrorStr : "Upload não é permitido",
							maxFileCountErrorStr : " não é permitido. Permitido no máximo:",
							downloadStr : "Download",
							customErrorKeyStr : "jquery-upload-file-error",
							showQueueDiv : false,
							statusBarWidth : 500,
							dragdropWidth : 500,
							showPreview : true,
							previewHeight : "auto",
							previewWidth : "100%"
						}, n);
		this.fileCounter = 1;
		this.selectedFiles = 0;
		this.fCounter = 0;
		this.sCounter = 0;
		this.tCounter = 0;
		var i = "ajax-file-upload-" + (new Date).getTime();
		this.formGroup = i;
		this.hide();
		this.errorLog = e("<div></div>");
		this.after(this.errorLog);
		this.responses = [];
		if (!t.formdata) {
			r.dragDrop = false
		}
		if (!t.formdata) {
			r.multiple = false
		}
		var s = this;
		var o = e("<div>" + e(this).html() + "</div>");
		e(o).addClass(r.uploadButtonClass);
		(function b() {
			if (e.fn.ajaxForm) {
				if (r.dragDrop) {
					var t = e(
							'<div class="ajax-upload-dragdrop" style="vertical-align:top;"></div>')
							.width(r.dragdropWidth);
					e(s).before(t);
					e(t).append(o);
					e(t).append(e(r.dragDropStr));
					f(s, r, t)
				} else {
					e(s).before(o)
				}
				r.onLoad.call(this, s);
				m(s, i, r, o)
			} else
				window.setTimeout(b, 10)
		})();
		this.startUpload = function() {
			e("." + this.formGroup).each(function(t, n) {
				if (e(this).is("form"))
					e(this).submit()
			})
		};
		this.getFileCount = function() {
			return s.selectedFiles
		};
		this.stopUpload = function() {
			e(".ajax-file-upload-abort").each(function(t, n) {
				if (e(this).hasClass(s.formGroup))
					e(this).click()
			})
		};
		this.cancelAll = function() {
			e(".ajax-file-upload-cancel").each(function(t, n) {
				if (e(this).hasClass(s.formGroup))
					e(this).click()
			})
		};
		this.update = function(t) {
			r = e.extend(r, t)
		};
		this.createProgress = function(e) {
			var t = new g(this, r);
			t.progressDiv.show();
			t.progressbar.width("100%");
			t.filename.html(s.fileCounter + r.fileCounterStyle + e);
			s.fileCounter++;
			s.selectedFiles++;
			if (r.showDownload) {
				t.download.show();
				t.download.click(function() {
					if (r.downloadCallback)
						r.downloadCallback.call(s, [ e ])
				})
			}
			t.del.show();
			t.del.click(function() {
				t.statusbar.hide().remove();
				var n = [ e ];
				if (r.deleteCallback)
					r.deleteCallback.call(this, n, t);
				s.selectedFiles -= 1;
				v(r, s)
			})
		};
		this.getResponses = function() {
			return this.responses
		};
		var u = false;
		return this
	}
})(jQuery)