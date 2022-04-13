let table = document.querySelector(".table");
let submit = document.querySelector("#submitBtn");
let count = 0;
let serialNumber = document.querySelector("#serialNumber");
let serialNumberList = [];
let text = document.querySelector("#text");
let allInput = document.querySelectorAll(".form-control");
let toExcel = document.querySelector("#toExcel");
let confirmBtn = document.querySelector("#confirmBtn");
let itemCodeData = "";
let itemCodeInput = document.querySelector("#itemCodeInput");
let locationData = "";
let locationInput = document.querySelector("#locationInput");
let successTone = new Audio(
  "https://www.zapsplat.com/wp-content/uploads/2015/sound-effects-61905/zapsplat_multimedia_correct_ping_tone_008_68785.mp3"
);
let errorTone = new Audio(
  "https://www.zapsplat.com/wp-content/uploads/2015/sound-effects-23735/zapsplat_multimedia_game_error_tone_001_24919.mp3"
);
let errorAlert = document.querySelector("#errorAlert");
let modalBody = document.querySelector(".modal-body");

let transFrom = document.querySelector("#fromInput").value;
let transTo = document.querySelector("#toInput").value;

/* export to Excel */
function exportToExcel() {
  let htmls = "";
  let uri = "data:application/vnd.ms-excel;base64,";
  let template =
    '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>';
  let base64 = function (s) {
    return window.btoa(unescape(encodeURIComponent(s)));
  };

  let format = function (s, c) {
    return s.replace(/{(\w+)}/g, function (m, p) {
      return c[p];
    });
  };

  htmls = document.querySelector(".table").innerHTML;

  let ctx = {
    worksheet: "Sheet1",
    table: htmls
  };

  let link = document.createElement("a");

  var options = { year: 'numeric', month: 'numeric', day: 'numeric' };

  let date = new Date().toLocaleString("en-TW", options);
  link.download = `Picking List ${transFrom}-${transTo} ${date}.xls`;
  link.href = uri + base64(format(template, ctx));
  link.click();
}

toExcel.addEventListener("click", exportToExcel);
// ^ excel
