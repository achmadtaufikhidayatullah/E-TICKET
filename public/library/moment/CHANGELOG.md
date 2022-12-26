Changelog
=========

### 2.29.4

* Release Jul 6, 2022
  * [#6015](https://github.com/moment/moment/pull/6015) [bugfix] Fix ReDoS in preprocessRFC2822 regex

### 2.29.3 [Full changelog](https://gist.github.com/ichernev/edebd440f49adcaec72e5e77b791d8be)

* Release Apr 17, 2022
  * [#5995](https://github.com/moment/moment/pull/5995) [bugfix] Remove const usage
  * [#5990](https://github.com/moment/moment/pull/5990) misc: fix advisory link


### 2.29.2 [See full changelog](https://gist.github.com/ichernev/1904b564f6679d9aac1ae08ce13bc45c)

* Release Apr 3 2022

Address https://github.com/moment/moment/security/advisories/GHSA-8hfj-j24r-96c4

### 2.29.1 [See full changelog](https://gist.github.com/marwahaha/cc478ba01a1292ab4bd4e861d164d99b)

* Release Oct 6, 2020

Updated deprecation message, bugfix in hi locale

### 2.29.0 [See full changelog](https://gist.github.com/marwahaha/b0111718641a6461800066549957ec14)

* Release Sept 22, 2020

New locales (es-mx, bn-bd).
Minor bugfixes and locale improvements.
More tests.
Moment is in maintenance mode. Read more at this link:
https://momentjs.com/docs/#/-project-status/

### 2.28.0 [See full changelog](https://gist.github.com/marwahaha/028fd6c2b2470b2804857cfd63c0e94f)

* Release Sept 13, 2020

Fix bug where .format() modifies original instance, and locale updates

### 2.27.0 [See full changelog](https://gist.github.com/marwahaha/5100c9c2f42019067b1f6cefc333daa7)

* Release June 18, 2020

Added Turkmen locale, other locale improvements, slight TypeScript fixes

### 2.26.0 [See full changelog](https://gist.github.com/marwahaha/0725c40740560854a849b096ea7b7590)

* Release May 19, 2020

TypeScript fixes and many locale improvements

### 2.25.3

* Release May 4, 2020

Remove package.json module property. It looks like webpack behaves differently
for modules loaded via module vs jsnext:main.

### 2.25.2

* Release May 4, 2020

This release includes ES Module bundled moment, separate from it's source code
under dist/ folder. This might alleviate issues with finding the `./locale
subfolder for loading locales. This might also mean now webpack will bundle all
locales automatically, unless told otherwise.

### 2.25.1

* Release May 1, 2020

This is a quick patch release to address some of the issues raised after
releasing 2.25.0.

* [2e268635](https://github.com/moment/moment/commit/2e268635) [misc] Revert #5269 due to webpack warning
* [226799e1](https://github.com/moment/moment/commit/226799e1) [locale] fil: Fix metadata comment
* [a83a521](https://github.com/moment/moment/commit/a83a521) [bugfix] Fix typeoff usages
* [e324334](https://github.com/moment/moment/commit/e324334) [pkg] Add ts3.1-typings in npm package
* [28cc23e](https://github.com/moment/moment/commit/28cc23e) [misc] Remove deleted generated locale en-SG

### 2.25.0 [See full changelog](https://gist.github.com/ichernev/6148e64df2427e455b10ce6a18de1a65)

* Release May 1, 2020

* [#4611](https://github.com/moment/moment/issues/4611) [022dc038](https://github.com/moment/moment/commit/022dc038) [feature] Support for strict string parsing, fixes [#2469](https://github.com/moment/moment/issues/2469)
* [#4599](https://github.com/moment/moment/issues/4599) [4b615b9d](https://github.com/moment/moment/commit/4b615b9d) [feature] Add support for eras in en and jp
* [#4296](https://github.com/moment/moment/issues/4296) [757d4ff8](https://github.com/moment/moment/commit/757d4ff8) [feature] Accept custom relative thresholds in duration.humanize

* 18 bigfixes
* 36 locale fixes
* 5 new locales (oc-lnc, zh-mo, en-in, gom-deva, fil)

### 2.24.0 [See full changelog](https://gist.github.com/marwahaha/12366fe45bee328f33acf125d4cd540e)

* Release Jan 21, 2019

* [#4338](https://github.com/moment/moment/pull/4338) [bugfix] Fix startOf/endOf DST issues while boosting performance
* [#4553](https://github.com/moment/moment/pull/4553) [feature] Add localeSort param to Locale weekday methods
* [#4887](https://github.com/moment/moment/pull/4887) [bugfix] Make Duration#as work with quarters
* 3 new locales (it-ch, ga, en-SG)
* Lots of locale improvements

### 2.23.0 [See full changelog](https://gist.github.com/marwahaha/eadb7ac11b761290399a576f8b2419a5)

* Release Dec 12, 2018

* [#4863](https://github.com/moment/moment/pull/4863) [new locale] added Kurdish language (ku)
* [#4417](https://github.com/moment/moment/pull/4417) [bugfix] isBetween should return false for invalid dates
* [#4700](https://github.com/moment/moment/pull/4700) [bugfix] Fix [#4698](https://github.com/moment/moment/pull/4698): Use ISO WeekYear for HTML5_FMT.WEEK
* [#4563](https://github.com/moment/moment/pull/4563) [feature] Fix [#4518](https://github.com/moment/moment/pull/4518): Add support to add/subtract ISO weeks
* other locale changes, build process changes, typos

### 2.22.2 [See full changelog](https://gist.github.com/marwahaha/4d992c13c2dbc0f59d4d8acae1dc6d3a)

* Release May 31, 2018

* [#4564](https://github.com/moment/moment/pull/4564) [bugfix] Avoid using trim()
* [#4453](https://github.com/moment/moment/pull/4453) [bugfix] Treat periods as periods, not regex-anything period, for weekday parsing in strict mode.
* Minor locale improvements (pa-in, be, az)

### 2.22.1 [See full changelog](https://gist.github.com/marwahaha/ff2cd13d0eda08afb7a237b10aae558c)

* Release Apr 14, 2018

* [#4495](https://github.com/moment/moment/pull/4495) [bugfix] Added HTML5_FMT to moment.d.ts
* Minor locale improvements
* QUnit upgrade and coveralls reporting

### 2.22.0 [See full changelog](https://gist.github.com/marwahaha/ae895025dac3f0641fa9ec2e36d282bb)

* Release Mar 30, 2018

* [#4423](https://github.com/moment/moment/pull/4423) [new locale] Added Mongolian locale mn
* Various locale improvements
* Minor misc changes

### 2.21.0 [See full changelog](https://gist.github.com/marwahaha/80d19ef882b71df1948df7865efdd40e)

* Release Mar 2, 2018

* [#4391](https://github.com/moment/moment/pull/4391) [bugfix] Fix [#4390](https://github.com/moment/moment/pull/4390): use offset properly in toISOString
* [#4310](https://github.com/moment/moment/pull/4310) [bugfix] Fix [#3883](https://github.com/moment/moment/pull/3883) lazy load parentLocale in defineLocale, fallback to global if missing
* [#4085](https://github.com/moment/moment/pull/4085) [misc] Print console warning when setting non-existent locales
* [#4371](https://github.com/moment/moment/pull/4371) [misc] fix deprecated rollup options
* New locales: ug-cn, en-il, tg
* Various locale improvements

### 2.20.1 [See changelog](https://gist.github.com/marwahaha/d72c1cb22076373be889b16272cbd187)

* Release Dec 18, 2017

* [#4359](https://github.com/moment/moment/pull/4359) [locale] Fix Arabic locale for months (again)
* [#4357](https://github.com/moment/moment/pull/4357) [misc] Add optional parameter keepOffset to toISOString

### 2.20.0 [See full changelog](https://gist.github.com/marwahaha/e0d4135fbf8bb75fa85c4aa2bddc5031)

* Release Dec 16, 2017

* [#4312](https://github.com/moment/moment/pull/4312) [bugfix] Fix [#4251](https://github.com/moment/moment/pull/4251): Avoid RFC2822 in utc() test
* [#4240](https://github.com/moment/moment/pull/4240) [bugfix] Fix incorrect strict parsing with full-width parentheses
* [#4341](https://github.com/moment/moment/pull/4341) [feature] Prevent toISOString converting to UTC (issue [#1751](https://github.com/moment/moment/pull/1751))
* [#4154](https://github.com/moment/moment/pull/4154) [feature] add format constants to support output to HTML5 input type formats (see [#3928](https://github.com/moment/moment/pull/3928))
* [#4143](https://github.com/moment/moment/pull/4143) [new locale] mt: Maltese language
* [#4183](https://github.com/moment/moment/pull/4183) [locale] Relative seconds i18n
* Various other locale improvements

### 2.19.4 [See changelog](https://gist.github.com/marwahaha/d3b7b0ddf4bdae512244f16e8cc59efb)

* Release Dec 10, 2017

* [#4332](https://github.com/moment/moment/pull/4332) [bugfix] Fix weekday verification for UTC and offset days (fixes [#4227](https://github.com/moment/moment/pull/4227))
* [#4336](https://github.com/moment/moment/pull/4336) [bugfix] Fix [#4334](https://github.com/moment/moment/pull/4334): Remove unused function call argument
* [#4246](https://github.com/moment/moment/pull/4246) [misc] Add 'ss' relative time key to typescript definition

### 2.19.3 [See changelog](https://gist.github.com/marwahaha/3654006bc0c2e522451c08d12c0bfabf)

* Release Nov 29, 2017

* [#4326](https://github.com/moment/moment/pull/4326) [bugfix] Fix for ReDOS vulnerability (see [#4163](https://github.com/moment/moment/issues/4163))
* [#4289](https://github.com/moment/moment/pull/4289) [misc] Fix spelling and formatting for U.S. for es-us

### 2.19.2 [See changelog (it's the same >:D)](https://gist.github.com/ichernev/76b1a3f33d3a8ff9665ce434a45221d0)

* Release Nov 11, 2017

* [#4255](https://github.com/moment/moment/pull/4255) [bugfix] Fix year setter for random days in a leap year, fixes [#4238](https://github.com/moment/moment/issues/4238)
* [#4242](https://github.com/moment/moment/pull/4242) [bugfix] updateLocale now tries to load parent, fixes [#3626](https://github.com/moment/moment/issues/3626)

### 2.19.1

* Release Oct 11, 2017

Make react native and webpack both work
* #4225 #4226 #4232

### 2.19.0 [See full changelog](https://gist.github.com/ichernev/5f3f4eb02761b4f765a0cccf02cec603)

* Release Oct 10, 2017

## Fix React Native 0.49+ crash
* [#4213](https://github.com/moment/moment/pull/4213) [critical] Rename dynamic
  require to avoid React Native crash
* [#4214](https://github.com/moment/moment/pull/4214) [fixup] Move require
  rename inside try/catch, fixes
  [#4213](https://github.com/moment/moment/issues/4213)

## Features

* [#3735](https://github.com/moment/moment/pull/3735) [feature] Ignore NaN values in setters
* [#4106](https://github.com/moment/moment/pull/4106) [fixup] Drop isNumeric utility fn, fixes [#3735](https://github.com/moment/moment/issues/3735)
* [#4080](https://github.com/moment/moment/pull/4080) [feature] Implement a clone method for durations, fixes [#4078](https://github.com/moment/moment/issues/4078)
* [#4215](https://github.com/moment/moment/pull/4215) [misc] TS: Add duration.clone(), for [#4080](https://github.com/moment/moment/issues/4080)

## Packaging

* [#4003](https://github.com/moment/moment/pull/4003) [pkg] bower: Remove tests from package
* [#3904](https://github.com/moment/moment/pull/3904) [pkg] jsnext:main -> module in package.json
* [#4060](https://github.com/moment/moment/pull/4060) [pkg] Account for new rollup interface

Bugfixes, new locales, locale fixes etc...

### 2.18.1

* Release Mar 22, 2017

* [#3853](https://github.com/moment/moment/pull/3853) [misc] Fix invalid whitespace character causing inability to parse
  moment.js

### 2.18.0 [See full changelog](https://gist.github.com/ichernev/78920c5a1e419fb28c6e4546d1b7235c)

* Release Mar 18, 2017

## Features

* [#3708](https://github.com/moment/moment/pull/3708) [feature] RFC2822 parsing
* [#3611](https://github.com/moment/moment/pull/3611) [feature] Durations gain validity
* [#3738](https://github.com/moment/moment/pull/3738) [feature] Enable relative time for multiple seconds, request [#2558](https://github.com/moment/moment/issues/2558)
* [#3766](https://github.com/moment/moment/pull/3766) [feature] Add support for k and kk format parsing

## Bugfixes

* [#3643](https://github.com/moment/moment/pull/3643) [bugfix] Fixes [#3520](https://github.com/moment/moment/issues/3520), parseZone incorrectly handled minutes under 16
* [#3710](https://github.com/moment/moment/pull/3710) [bugfix] Fixes [#3632](https://github.com/moment/moment/issues/3632), toISOString returns null for invalid date
* [#3787](https://github.com/moment/moment/pull/3787) [bugfix] Fixes [#3717](https://github.com/moment/moment/issues/3717), ensure day-of-year is non-zero
* [#3780](https://github.com/moment/moment/pull/3780) [bugfix] Fixes [#3765](https://github.com/moment/moment/issues/3765): Ensure year 0 is formatted with YYYY
* [#3806](https://github.com/moment/moment/pull/3806) [bugfix] Fixes [#3805](https://github.com/moment/moment/issues/3805), fix locale month getters for standalone/format cases

7 new locales, many locale improvements and some misc changes

### 2.17.1 [Also available here](https://gist.github.com/ichernev/f38280b2b29c4932914a6d3a4e50bfb2)
* Release Dec 03, 2016

* [#3638](https://github.com/moment/moment/pull/3638) [misc] TS: Make typescript definitions work with 1.x
* [#3628](https://github.com/moment/moment/pull/3628) [misc] Adds "sign CLA" link to `CONTRIBUTING.md`
* [#3640](https://github.com/moment/moment/pull/3640) [misc] Fix locale issues

### 2.17.0 [Also available here](https://gist.github.com/ichernev/ed58f76fb95205eeac653d719972b90c)
* Release Nov 22, 2016

* [#3435](https://github.com/moment/moment/pull/3435) [new locale] yo: Yoruba (Nigeria) locale
* [#3595](https://github.com/moment/moment/pull/3595) [bugfix] Fix accidental reference to global "value" variable
* [#3506](https://github.com/moment/moment/pull/3506) [bugfix] Fix invalid moments returning valid dates to method calls
* [#3563](https://github.com/moment/moment/pull/3563) [locale] ca: Change future relative time
* [#3504](https://github.com/moment/moment/pull/3504) [tests] Fixes [#3463](https://github.com/moment/moment/issues/3463), parseZone not handling Z correctly (tests only)
* [#3591](https://github.com/moment/moment/pull/3591) [misc] typescript: update typescript to 2.0.8, add strictNullChecks=true
* [#3597](https://github.com/moment/moment/pull/3597) [misc] Fixed capitalization in nuget spec

### 2.16.0 [See full changelog](https://gist.github.com/ichernev/17bffc1005a032cb1a8ac4c1558b4994)
* Release Nov 9, 2016

## Features
* [#3530](https://github.com/moment/moment/pull/3530) [feature] Check whether input is date before checking if format is array
* [#3515](https://github.com/moment/moment/pull/3515) [feature] Fix [#2300](https://github.com/moment/moment/issues/2300): Default to current week.

## Bugfixes
* [#3546](https://github.com/moment/moment/pull/3546) [bugfix] Implement lazy-loading of child locales with missing prents
* [#3523](https://github.com/moment/moment/pull/3523) [bugfix] parseZone should handle UTC
* [#3502](https://github.com/moment/moment/pull/3502) [bugfix] Fix [#3500](https://github.com/moment/moment/issues/3500): ISO 8601 parsing should match the full string, not the beginning of the string.
* [#3581](https://github.com/moment/moment/pull/3581) [bugfix] Fix parseZone, redo [#3504](https://github.com/moment/moment/issues/3504), fix [#3463](https://github.com/moment/moment/issues/3463)

## New Locales
* [#3416](https://github.com/moment/moment/pull/3416) [new locale] nl-be: Dutch (Belgium) locale
* [#3393](https://github.com/moment/moment/pull/3393) [new locale] ar-dz: Arabic (Algeria) locale
* [#3342](https://github.com/moment/moment/pull/3342) [new locale] tet: Tetun Dili (East Timor) locale

And more locale, build and typescript improvements

### 2.15.2
* Release Oct 23, 2016
* [#3525](https://github.com/moment/moment/pull/3525) Speedup month standalone/format regexes **(IMPORTANT)**
* [#3466](https://github.com/moment/moment/pull/3466) Fix typo of Javanese

### 2.15.1
* Release Sept 20, 2016
* [#3438](https://github.com/moment/moment/pull/3438) Fix locale autoload, revert [#3344](https://github.com/moment/moment/pull/3344)

### 2.15.0 [See full changelog](https://gist.github.com/ichernev/10e1c5bf647545c72ca30e9628a09ed3)
- Release Sept 12, 2016

## New Locales
* [#3255](https://github.com/moment/moment/pull/3255) [new locale] mi: Maori language
* [#3267](https://github.com/moment/moment/pull/3267) [new locale] ar-ly: Arabic (Libya) locale
* [#3333](https://github.com/moment/moment/pull/3333) [new locale] zh-hk: Chinese (Hong Kong) locale

## Bugfixes
* [#3276](https://github.com/moment/moment/pull/3276) [bugfix] duration: parser: Support ms durations in .NET syntax
* [#3312](https://github.com/moment/moment/pull/3312) [bugfix] locales: Enable locale-data getters without moment (fixes [#3284](https://github.com/moment/moment/issues/3284))
* [#3381](https://github.com/moment/moment/pull/3381) [bugfix] parsing: Fix parseZone without timezone in string, fixes [#3083](https://github.com/moment/moment/issues/3083)
* [#3383](https://github.com/moment/moment/pull/3383) [bugfix] toJSON: Fix isValid so that toJSON works after a moment is frozen
* [#3427](https://github.com/moment/moment/pull/3427) [bugfix] ie8: Fix IE8 (regression in 2.14.x)

## Packaging
* [#3299](https://github.com/moment/moment/pull/3299) [pkg] npm: Do not include .npmignore in npm package
* [#3273](https://github.com/moment/moment/pull/3273) [pkg] jspm: Include moment.d.ts file in package
* [#3344](https://github.com/moment/moment/pull/3344) [pkg] exports: use module.require for nodejs

Also some locale and typescript improvements

### 2.14.1
- Release July 20, 2016
* [#3280](https://github.com/moment/moment/pull/3280) Fix typescript definitions


### 2.14.0 [See full changelog](https://gist.github.com/ichernev/812e79ac36a7829a22598fe964bfc18a)

- Release July 20, 2016

## New Features
* [#3233](https://github.com/moment/moment/pull/3233) Introduce month.isFormat for format/standalone discovery
* [#2848](https://github.com/moment/moment/pull/2848) Allow user to get/set the rounding method used when calculating relative time
* [#3112](https://github.com/moment/moment/pull/3112) optimize configFromStringAndFormat
* [#3147](https://github.com/moment/moment/pull/3147) Call calendar format function with moment context
* [#3160](https://github.com/moment/moment/pull/3160) deprecate isDSTShifted
* [#3175](https://github.com/moment/moment/pull/3175) make moment calendar extensible with ad-hoc options
* [#3191](https://github.com/moment/moment/pull/3191) toDate returns a copy of the internal date object
* [#3192](https://github.com/moment/moment/pull/3192) Adding support for rollup import.
* [#3238](https://github.com/moment/moment/pull/3238) Handle empty object and empty array for creation as now
* [#3082](https://github.com/moment/moment/pull/3082) Use relative AMD moment dependency

## Bugfixes
* [#3241](https://github.com/moment/moment/pull/3241) Escape all 24 mixed pieces, not only first 12 in computeMonthsParse
* [#3008](https://github.com/moment/moment/pull/3008) Object setter orders sets based on size of unit
* [#3177](https://github.com/moment/moment/pull/3177) Bug Fix [#2704](https://github.com/moment/moment/pull/2704) - isoWeekday(String) inconsistent with isoWeekday(Number)
* [#3230](https://github.com/moment/moment/pull/3230) fix passing date with format string to ignore format string
* [#3232](https://github.com/moment/moment/pull/3232) Fix negative 0 in certain diff cases
* [#3235](https://github.com/moment/moment/pull/3235) Use proper locale inheritance for the base locale, fixes [#3137](https://github.com/moment/moment/pull/3137)

Plus es-do locale and locale bugfixes

### 2.13.0 [See full changelog](https://gist.github.com/ichernev/0132fcf5b61f7fc140b0bb0090480d49)
- Release April 18, 2016

## Enhancements:
* [#2982](https://github.com/moment/moment/pull/2982) Add 'date' as alias to 'day' for startOf() and endOf().
* [#2955](https://github.com/moment/moment/pull/2955) Add parsing negative components in durations when ISO 8601
* [#2991](https://github.com/moment/moment/pull/2991) isBetween support for both open and closed intervals
* [#3105](https://github.com/moment/moment/pull/3105) Add localeSorted argument to weekday listers
* [#3102](https://github.com/moment/moment/pull/3102) Add k and kk formatting tokens

## Bugfixes
* [#3109](https://github.com/moment/moment/pull/3109) Fix [#1756](https://github.com/moment/moment/issues/1756) Resolved thread-safe issue on server side.
* [#3078](https://github.com/moment/moment/pull/3078) Fix parsing for months/weekdays with weird characters
* [#3098](https://github.com/moment/moment/pull/3098) Use Z suffix when in UTC mode ([#3020](https://github.com/moment/moment/issues/3020))
* [#2995](https://github.com/moment/moment/pull/2995) Fix floating point rounding errors in durations
* [#3059](https://github.com/moment/moment/pull/3059) fix bug where diff returns -0 in month-related diffs
* [#3045](https://github.com/moment/moment/pull/3045) Fix mistaking any input for 'a' token
* [#2877](https://github.com/moment/moment/pull/2877) Use explicit .valueOf() calls instead of coercion
* [#3036](https://github.com/moment/moment/pull/3036) Year setter should keep time when DST changes

Plus 3 new locales and locale fixes.

### 2.12.0 [See full changelog](https://gist.github.com/ichernev/6e5bfdf8d6522fc4ac73)

- Release March 7, 2016

## Enhancements:
* [#2932](https://github.com/moment/moment/pull/2932) List loaded locales
* [#2818](https://github.com/moment/moment/pull/2818) Parse ISO-8061 duration containing both day and week values
* [#2774](https://github.com/moment/moment/pull/2774) Implement locale inheritance and locale updating

## Bugfixes:
* [#2970](https://github.com/moment/moment/pull/2970) change add subtract to handle decimal values by rounding
* [#2887](https://github.com/moment/moment/pull/2887) Fix toJSON casting of invalid moment
* [#2897](https://github.com/moment/moment/pull/2897) parse string arguments for month() correctly, closes #2884
* [#2946](https://github.com/moment/moment/pull/2946) Fix usage suggestions for min and max

## New locales:
* [#2917](https://github.com/moment/moment/pull/2917) Locale Punjabi(Gurmukhi) India format conversion

And more

### 2.11.2 (Fix ReDoS attack vector)

- Release February 7, 2016

* [#2939](https://github.com/moment/moment/pull/2939) use full-string match to speed up aspnet regex match

### 2.11.1 [See full changelog](https://gist.github.com/ichernev/8ec3ee25b749b4cff3c2)

- Release January 9, 2016

## Bugfixes:
* [#2881](https://github.com/moment/moment/pull/2881) Revert "Merge pull request #2746 from mbad0la:develop" Sep->Sept
* [#2868](https://github.com/moment/moment/pull/2868) Add format and parse token Y, so it actually works
* [#2865](https://github.com/moment/moment/pull/2865) Use typeof checks for undefined for global variables
* [#2858](https://github.com/moment/moment/pull/2858) Fix Date mocking regression introduced in 2.11.0
* [#2864](https://github.com/moment/moment/pull/2864) Include changelog in npm release
* [#2830](https://github.com/moment/moment/pull/2830) dep: add grunt-cli
* [#2869](https://github.com/moment/moment/pull/2869) Fix months parsing for some locales

### 2.11.0 [See full changelog](https://gist.github.com/ichernev/6594bc29719dde6b2f66)

- Release January 4, 2016

* [#2624](https://github.com/moment/moment/pull/2624) Proper handling of invalid moments
* [#2634](https://github.com/moment/moment/pull/2634) Fix strict month parsing issue in cs,ru,sk
* [#2735](https://github.com/moment/moment/pull/2735) Reset the locale back to 'en' after defining all locales in min/locales.js
* [#2702](https://github.com/moment/moment/pull/2702) Week rework
* [#2746](https://github.com/moment/moment/pull/2746) Changed September Abbreviation to "Sept" in locale-specific english
  files and default locale file
* [#2646](https://github.com/moment/moment/pull/2646) Fix [#2645](https://github.com/moment/moment/pull/2645) - invalid dates pre-1970

* [#2641](https://github.com/moment/moment/pull/2641) Implement basic format and comma as ms separator in ISO 8601
* [#2665](https://github.com/moment/moment/pull/2665) Implement stricter weekday parsing
* [#2700](https://github.com/moment/moment/pull/2700) Add [Hh]mm and [Hh]mmss formatting tokens, so you can parse 123 with
  hmm for example
* [#2565](https://github.com/moment/moment/pull/2565) [#2835](https://github.com/moment/moment/pull/2835) Expose arguments used for moment creation with creationData
  (fix [#2443](https://github.com/moment/moment/pull/2443))
* [#2648](https://github.com/moment/moment/pull/2648) fix issue [#2640](https://github.com/moment/moment/pull/2640): support instanceof operator
* [#2709](https://github.com/moment/moment/pull/2709) Add isSameOrAfter and isSameOrBefore comparison methods
* [#2721](https://github.com/moment/moment/pull/2721) 