/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */
define("jquery-nos-inspector-model",["jquery-nos-listgrid","jquery-ui.datepicker"],function(a){a.fn.extend({nosInspectorModel:function(){return this.each(function(){var h=a(this),c=h.attr("id"),g=h.closest(".nos-dispatcher, body").on("contextChange",function(){b();if(i.contextChange){h.noslistgrid("ensureControl",true)}}),k=h.parent().on({widgetResize:function(){h.noslistgrid("setSize",k.width(),k.height())},widgetReload:function(){var l=Math.floor((k.height()-e.footer-e.header-(d?e.filter:0))/e.row);if(l!=j){j=l;h.noslistgrid("option","pageSize",j)}else{h.noslistgrid("ensureControl",true)}}}),i=k.data("inspector"),e=a.grid.getHeights(),d=i.grid.showFilter||false,f=false,j=Math.floor((k.height()-e.footer-e.header-(d?e.filter:0))/e.row),b=function(){if(i.reloadEvent){h.nosUnlistenEvent("inspector"+c);var l={name:i.reloadEvent};if(g.data("nosContext")){l.context=g.data("nosContext")}h.nosListenEvent(l,function(){k.trigger("widgetReload")},"inspector"+c)}};b();h.css({height:"100%",width:"100%"}).noslistgrid({columnsAutogenerationMode:"none",showFilter:d,allowSorting:true,scrollMode:"auto",allowPaging:true,pageIndex:0,pageSize:j,allowColSizing:true,allowColMoving:true,loadingText:i.loadingText||"Loading...",columns:i.grid.columns,data:new wijdatasource({dynamic:true,proxy:new wijhttpproxy({url:i.grid.urlJson,dataType:"json",error:function(l,n,m){log(l,n,m)},data:{}}),loading:function(n,l){var m=l.data.paging;n.proxy.options.data.context=g.data("nosContext")||"";n.proxy.options.data.offset=m.pageIndex*m.pageSize;n.proxy.options.data.limit=m.pageSize},reader:{read:function(m){var l=parseInt(m.data.total,10);m.data=m.data.items;m.data.totalRows=l}}}),noCellsSelected:true,currentCellChanged:function(m){var n=a(m.target).noslistgrid("currentCell").row(),l=n?n.data:false;if(l&&f){i.selectionChanged(l.id,l._title)}h.noslistgrid("currentCell",-1,-1)},rendering:function(){f=false},rendered:function(){f=true;h.css("height","auto")}})})}});return a});