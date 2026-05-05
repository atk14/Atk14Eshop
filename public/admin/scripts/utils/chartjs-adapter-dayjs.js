// Chart.js date adapter using dayjs (drop-in replacement for chartjs-adapter-moment)
(function(global, factory) {
  if (typeof exports === "object" && typeof module !== "undefined") {
    factory(require("dayjs"), require("chart.js"));
  } else if (typeof define === "function" && define.amd) {
    define(["dayjs", "chart.js"], factory);
  } else {
    factory(
      (typeof globalThis !== "undefined" ? globalThis : global || self).dayjs,
      (typeof globalThis !== "undefined" ? globalThis : global || self).Chart
    );
  }
}(this, function(dayjs, Chart) {
  "use strict";

  // Register plugins before the adapter runs
  dayjs.extend(dayjs_plugin_customParseFormat);
  dayjs.extend(dayjs_plugin_isoWeek);
  dayjs.extend(dayjs_plugin_localizedFormat);

  Chart._adapters._date.override({
    _id: "dayjs",

    formats: function() {
      return {
        datetime:    "MMM D, YYYY, h:mm:ss a",
        millisecond: "h:mm:ss.SSS a",
        second:      "h:mm:ss a",
        minute:      "h:mm a",
        hour:        "hA",
        day:         "MMM D",
        week:        "ll",
        month:       "MMM YYYY",
        quarter:     "[Q]Q - YYYY",
        year:        "YYYY",
      };
    },

    parse: function(value, format) {
      const d = (typeof value === "string" && typeof format === "string")
        ? dayjs(value, format)
        : dayjs(value);
      return d.isValid() ? d.valueOf() : null;
    },

    format: function(time, format) {
      return dayjs(time).format(format);
    },

    add: function(time, amount, unit) {
      return dayjs(time).add(amount, unit).valueOf();
    },

    diff: function(max, min, unit) {
      return dayjs(max).diff(dayjs(min), unit);
    },

    startOf: function(time, unit, weekday) {
      const d = dayjs(time);
      if (unit === "isoWeek") {
        weekday = Math.trunc(Math.min(Math.max(0, weekday), 6));
        return d.isoWeekday(weekday).startOf("day").valueOf();
      }
      return d.startOf(unit).valueOf();
    },

    endOf: function(time, unit) {
      return dayjs(time).endOf(unit).valueOf();
    },
  });

}));
