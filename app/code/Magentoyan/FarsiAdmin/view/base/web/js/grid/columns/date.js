define([
    "jquery",
    "uiGridColumnsActions",
    'moment'
], function ($, Component, moment) {
    "use strict";

    //return Component;

    return Component.extend({


        getLabel: function (value, format) {

            var date = moment(this._super());
            /*date = date.isValid() && value[this.index] ?
                    date.format(format || this.dateFormat) :
                    '';*/

            //  majidian
            date = date.isValid() && value[this.index] ?
                date.format('YYYY-MM-D HH:mm:ss') :
                '';

            if(date == '')
                var auxDate = value[this.index];
            else
                var auxDate = date;

            

            try {
                date = auxDate;
                var auxAr1 = date.split(' ');

                var auxAr2 = auxAr1[0].split('-');

                var jalaliDate = this.gregorianToJalali(parseInt(auxAr2[0]), parseInt(auxAr2[1]), parseInt(auxAr2[2]));

                if (typeof auxAr1[1] != 'undefined' && auxAr1[1]) {
                    var auxAr3 = auxAr1[1].split(':');
                    var theTime = this.formatAMPM(parseInt(auxAr3[0]), parseInt(auxAr3[1]), parseInt(auxAr3[2]));
                    return jalaliDate + ' ' + theTime;
                }else
                    return jalaliDate;

                
            }catch (e) {
                return value[this.index];//date;
            }
            //majidian end


        },

        formatAMPM: function (hours, minutes, seconds) {

            var ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0' + minutes : minutes;
            var strTime = hours + ':' + minutes + ' ' + ampm;
            return strTime;
        },

        normalizeDate: function (dateString) {

            //YYYY-MM-DD
            var regEx = /^\d{4}-\d{2}-\d{2}$/;
            if (dateString.match(regEx))
                return dateString;

            //YYYY-MM-DD Time

            var auxAr1 = dateString.split(' ');
            var regEx = /^\d{4}-\d{2}-\d{2}$/;
            if (auxAr1[0].match(regEx))
                return dateString;

            //MMM d, YYYY
            if (moment(dateString, "MMM d, YYYY").isValid())
            {
                var monthAr = ["-", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                var auxAr1 = dateString.split(' ');
                var monthStr = auxAr1[0];
                var yearStr = auxAr1[2];
                var dayStr = auxAr1[1].slice(0, -1);

                monthStr = $.inArray(monthStr, monthAr);

                monthStr = parseInt(monthStr) < 10 ? '0' + parseInt(monthStr) : monthStr;
                dayStr = parseInt(dayStr) < 10 ? '0' + parseInt(dayStr) : dayStr;

               
                return yearStr + '-' + monthStr + '-' + dayStr;
            }

            //MMM d, YYYY h:mm:ss A
            if (moment(dateString, "MMM d, YYYY h:mm:ss A").isValid())
            {
                var monthAr = ["-", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                var auxAr1 = dateString.split(' ');
                var monthStr = auxAr1[0];
                var yearStr = auxAr1[2];
                var dayStr = auxAr1[1].slice(0, -1);

                monthStr = $.inArray(monthStr, monthAr);

                monthStr = parseInt(monthStr) < 10 ? '0' + parseInt(monthStr) : monthStr;
                dayStr = parseInt(dayStr) < 10 ? '0' + parseInt(dayStr) : dayStr;

                var timePart = '';
                for (var i = 0; i < auxAr1.length; i++)
                    if (i > 2)
                        timePart = timePart + ' ' + auxAr1[i];

                
                return yearStr + '-' + monthStr + '-' + dayStr + timePart;
            }

            return false;


        },

        gregorianToJalali: function (year, month, day) {
            var week = new Array("يكشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنج شنبه", "جمعه", "شنبه");
            var months = new Array("فروردين", "ارديبهشت", "خرداد", "تير", "مرداد", "شهريور", "مهر", "آبان", "آذر", "دي", "بهمن", "اسفند");


            if (year == 0) {
                year = 2000;
            }
            if (year < 100) {
                year += 1900;
            }
            var y = 1;
            for (var i = 0; i < 3000; i += 4) {
                if (year == i) {
                    y = 2;
                }
            }
            for (i = 1; i < 3000; i += 4) {
                if (year == i) {
                    y = 3;
                }
            }
            if (y == 1) {
                year -= ((month < 3) || ((month == 3) && (day < 21))) ? 622 : 621;
                switch (month) {
                    case 1:
                        (day < 21) ? (month = 10, day += 10) : (month = 11, day -= 20);
                        break;
                    case 2:
                        (day < 20) ? (month = 11, day += 11) : (month = 12, day -= 19);
                        break;
                    case 3:
                        (day < 21) ? (month = 12, day += 9) : (month = 1, day -= 20);
                        break;
                    case 4:
                        (day < 21) ? (month = 1, day += 11) : (month = 2, day -= 20);
                        break;
                    case 5:
                    case 6:
                        (day < 22) ? (month -= 3, day += 10) : (month -= 2, day -= 21);
                        break;
                    case 7:
                    case 8:
                    case 9:
                        (day < 23) ? (month -= 3, day += 9) : (month -= 2, day -= 22);
                        break;
                    case 10:
                        (day < 23) ? (month = 7, day += 8) : (month = 8, day -= 22);
                        break;
                    case 11:
                    case 12:
                        (day < 22) ? (month -= 3, day += 9) : (month -= 2, day -= 21);
                        break;
                    default:
                        break;
                }
            }
            if (y == 2) {
                year -= ((month < 3) || ((month == 3) && (day < 20))) ? 622 : 621;
                switch (month) {
                    case 1:
                        (day < 21) ? (month = 10, day += 10) : (month = 11, day -= 20);
                        break;
                    case 2:
                        (day < 20) ? (month = 11, day += 11) : (month = 12, day -= 19);
                        break;
                    case 3:
                        (day < 20) ? (month = 12, day += 10) : (month = 1, day -= 19);
                        break;
                    case 4:
                        (day < 20) ? (month = 1, day += 12) : (month = 2, day -= 19);
                        break;
                    case 5:
                        (day < 21) ? (month = 2, day += 11) : (month = 3, day -= 20);
                        break;
                    case 6:
                        (day < 21) ? (month = 3, day += 11) : (month = 4, day -= 20);
                        break;
                    case 7:
                        (day < 22) ? (month = 4, day += 10) : (month = 5, day -= 21);
                        break;
                    case 8:
                        (day < 22) ? (month = 5, day += 10) : (month = 6, day -= 21);
                        break;
                    case 9:
                        (day < 22) ? (month = 6, day += 10) : (month = 7, day -= 21);
                        break;
                    case 10:
                        (day < 22) ? (month = 7, day += 9) : (month = 8, day -= 21);
                        break;
                    case 11:
                        (day < 21) ? (month = 8, day += 10) : (month = 9, day -= 20);
                        break;
                    case 12:
                        (day < 21) ? (month = 9, day += 10) : (month = 10, day -= 20);
                        break;
                    default:
                        break;
                }
            }
            if (y == 3) {
                year -= ((month < 3) || ((month == 3) && (day < 21))) ? 622 : 621;
                switch (month) {
                    case 1:
                        (day < 20) ? (month = 10, day += 11) : (month = 11, day -= 19);
                        break;
                    case 2:
                        (day < 19) ? (month = 11, day += 12) : (month = 12, day -= 18);
                        break;
                    case 3:
                        (day < 21) ? (month = 12, day += 10) : (month = 1, day -= 20);
                        break;
                    case 4:
                        (day < 21) ? (month = 1, day += 11) : (month = 2, day -= 20);
                        break;
                    case 5:
                    case 6:
                        (day < 22) ? (month -= 3, day += 10) : (month -= 2, day -= 21);
                        break;
                    case 7:
                    case 8:
                    case 9:
                        (day < 23) ? (month -= 3, day += 9) : (month -= 2, day -= 22);
                        break;
                    case 10:
                        (day < 23) ? (month = 7, day += 8) : (month = 8, day -= 22);
                        break;
                    case 11:
                    case 12:
                        (day < 22) ? (month -= 3, day += 9) : (month -= 2, day -= 21);
                        break;
                    default:
                        break;
                }
            }


            if (month < 10)
                month = '0' + month;

            if (day < 10)
                day = '0' + day;

            return year + '/' + month + '/' + day;
        },

        initialize: function () {
            this._super();
        }
    });
});