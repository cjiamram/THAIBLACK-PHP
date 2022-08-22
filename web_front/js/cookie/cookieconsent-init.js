var LOREM_IPSUM = 'เว็บไซต์ของเราใช้คุกกี้ที่จำเป็นเพื่อให้แน่ใจว่ามีการทำงานที่เหมาะสมและติดตามคุกกี้เพื่อทำความเข้าใจว่าคุณโต้ตอบกับมันอย่างไร หลังจะถูกตั้งค่าหลังจากยินยอมเท่านั้น';
var WWW_HOST = 'https://nrrudataservice.nrru.ac.th/';

// obtain cookieconsent plugin
var cc = initCookieConsent();

// run plugin with config object
cc.run({
    current_lang: 'th',
    autoclear_cookies: true, // default: false
    cookie_name: 'cc_cookie_google', // default: 'cc_cookie'
    cookie_expiration: 365, // default: 182
    page_scripts: true, // default: false
    force_consent: true, // default: false

    // auto_language: null,                     // default: null; could also be 'browser' or 'document'
    // autorun: true,                           // default: true
    // delay: 0,                                // default: 0
    // hide_from_bots: false,                   // default: false
    // remove_cookie_tables: false              // default: false
    // cookie_domain: location.hostname,        // default: current domain
    // cookie_path: '/',                        // default: root
    // cookie_same_site: 'Lax',
    // use_rfc_cookie: false,                   // default: false
    // revision: 0,                             // default: 0

    gui_options: {
        consent_modal: {
            layout: 'cloud', // box,cloud,bar
            position: 'bottom center', // bottom,middle,top + left,right,center
            transition: 'slide' // zoom,slide
        },
        settings_modal: {
            layout: 'bar', // box,bar
            position: 'left', // right,left (available only if bar layout selected)
            transition: 'slide' // zoom,slide
        }
    },

    onFirstAction: function() {
        console.log('onFirstAction fired');
    },

    onAccept: function(cookie) {
        console.log('onAccept fired!')
    },

    onChange: function(cookie, changed_preferences) {
        console.log('onChange fired!');

        // If analytics category is disabled => disable google analytics
        if (!cc.allowedCategory('analytics')) {
            typeof gtag === 'function' && gtag('consent', 'update', {
                'analytics_storage': 'denied'
            });
        }
    },

    languages: {
        'en': {
            consent_modal: {
                title: 'Hello traveller, it\'s cookie time!',
                description: 'Our website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it. The latter will be set only after consent. <a href="#privacy-policy" class="cc-link">Privacy policy</a>',
                primary_btn: {
                    text: 'Accept all',
                    role: 'accept_all' //'accept_selected' or 'accept_all'
                },
                secondary_btn: {
                    text: 'Preferences',
                    role: 'settings' //'settings' or 'accept_necessary'
                },
                revision_message: '<br><br> Dear user, terms and conditions have changed since the last time you visisted!'
            },
            settings_modal: {
                title: 'Cookie settings',
                save_settings_btn: 'Save current selection',
                accept_all_btn: 'Accept all',
                reject_all_btn: 'Reject all',
                close_btn_label: 'Close',
                cookie_table_headers: [
                    { col1: 'Name' },
                    { col2: 'Domain' },
                    { col3: 'Expiration' }
                ],
                blocks: [{
                    title: 'Cookie usage',
                    description: LOREM_IPSUM + ' <a href="#" class="cc-link">Privacy Policy</a>.'
                }, {
                    title: 'Strictly necessary cookies',
                    description: LOREM_IPSUM + LOREM_IPSUM + "<br><br>" + LOREM_IPSUM + LOREM_IPSUM,
                    toggle: {
                        value: 'necessary',
                        enabled: true,
                        readonly: true //cookie categories with readonly=true are all treated as "necessary cookies"
                    }
                }, {
                    title: 'Analytics & Performance cookies',
                    description: LOREM_IPSUM,
                    toggle: {
                        value: 'analytics',
                        enabled: false,
                        readonly: false
                    },
                    cookie_table: [{
                            col1: '^_ga',
                            col2: 'yourdomain.com',
                            col3: 'description ...',
                            is_regex: true
                        },
                        {
                            col1: '_gid',
                            col2: 'yourdomain.com',
                            col3: 'description ...',
                        },
                        {
                            col1: '_my_cookie',
                            col2: 'yourdomain.com',
                            col3: 'test cookie with custom path ...',
                            path: '/demo' // needed for autoclear cookies
                        }
                    ]
                }, {
                    title: 'Targeting & Advertising cookies',
                    description: 'If this category is deselected, <b>the page will reload when preferences are saved</b>... <br><br>(demo example with reload option enabled, for scripts like microsoft clarity which will re-set cookies and send beacons even after the cookies have been cleared by the cookieconsent\'s autoclear function)',
                    toggle: {
                        value: 'targeting',
                        enabled: false,
                        readonly: false,
                        reload: 'on_disable' // New option in v2.4, check readme.md
                    },
                    cookie_table: [{
                        col1: '^_cl', // New option in v2.4: regex (microsoft clarity cookies)
                        col2: 'yourdomain.com',
                        col3: 'These cookies are set by microsoft clarity',
                        // path: '/',               // New option in v2.4
                        is_regex: true // New option in v2.4
                    }]
                }, {
                    title: 'More information',
                    description: LOREM_IPSUM + ' <a class="cc-link" href="https://orestbida.com/contact/">Contact me</a>.',
                }]
            }
        }
    },

    languages: {
        'th': {
            consent_modal: {
                title: 'การเก็บและใช้คุกกี้ 🍪',
                description: 'เว็บไซต์ของเราใช้คุกกี้ที่จำเป็นเพื่อให้แน่ใจว่ามีการทำงานที่เหมาะสมและติดตามคุกกี้เพื่อทำความเข้าใจว่าคุณโต้ตอบกับมันอย่างไร หลังจะถูกตั้งค่าหลังจากยินยอมเท่านั้น <a href="https://cookieinformation.com/th/what-is-a-cookie-policy/" target="_blank" class="cc-link">นโยบายคุกกี้</a>',
                primary_btn: {
                    text: 'ยอมรับทั้งหมด',
                    role: 'accept_all' //'accept_selected' or 'accept_all'
                },
                secondary_btn: {
                    text: 'การตั้งค่าคุกกี้',
                    role: 'settings' //'settings' or 'accept_necessary'
                },
                revision_message: '<br><br> เรียนผู้ใช้ ข้อกำหนดและเงื่อนไขมีการเปลี่ยนแปลงตั้งแต่ครั้งล่าสุดที่คุณเข้าเยี่ยมชม!'
            },
            settings_modal: {
                title: 'การตั้งค่าคุกกี้ 🍪',
                save_settings_btn: 'บันทึกการเลือกปัจจุบัน',
                accept_all_btn: 'ยอมรับทั้งหมด',
                reject_all_btn: 'ปฏิเสธทั้งหมด',
                close_btn_label: 'Close',
                cookie_table_headers: [
                    { col1: 'Name' },
                    { col2: 'Domain' },
                    { col3: 'Expiration' }
                ],
                blocks: [{
                    title: 'การใช้คุกกี้',
                    description: LOREM_IPSUM + ' <a href="https://cookieinformation.com/th/what-is-a-cookie-policy/" target="_blank" class="cc-link">นโยบายคุกกี้</a>.'
                }, {
                    title: 'คุกกี้ที่จำเป็นอย่างเคร่งครัด',
                    description: LOREM_IPSUM + LOREM_IPSUM + "",
                    // + LOREM_IPSUM + LOREM_IPSUM
                    toggle: {
                        value: 'necessary',
                        enabled: true,
                        readonly: true //cookie categories with readonly=true are all treated as "necessary cookies"
                    }
                }, {
                    title: 'คุกกี้การวิเคราะห์และประสิทธิภาพ',
                    description: LOREM_IPSUM,
                    toggle: {
                        value: 'analytics',
                        enabled: false,
                        readonly: false
                    },
                    cookie_table: [{
                            col1: '^_ga',
                            col2: WWW_HOST,
                            col3: 'description ...',
                            is_regex: true
                        },
                        {
                            col1: '_gid',
                            col2: WWW_HOST,
                            col3: 'description ...',
                        },
                        {
                            col1: '_my_cookie',
                            col2: WWW_HOST,
                            col3: 'test cookie with custom path ...',
                            path: '/' // needed for autoclear cookies
                        }
                    ]
                }, {
                    title: 'คุกกี้กำหนดเป้าหมายและโฆษณา',
                    description: 'หากยกเลิกการเลือกหมวดหมู่นี้ <b>หน้าจะโหลดซ้ำเมื่อบันทึกการตั้งค่า</b>... <br><br>(ตัวอย่างการสาธิตที่เปิดใช้งานตัวเลือกการโหลดซ้ำ สำหรับสคริปต์ เช่น ความชัดเจนของ Microsoft ซึ่งจะตั้งค่าคุกกี้ใหม่และ ส่งบีคอนแม้ว่าคุกกี้จะถูกล้างโดยฟังก์ชันการล้างคำยินยอมอัตโนมัติของคุกกี้แล้วก็ตาม)',
                    toggle: {
                        value: 'targeting',
                        enabled: false,
                        readonly: false,
                        reload: 'on_disable' // New option in v2.4, check readme.md
                    },
                    cookie_table: [{
                        col1: '^_cl', // New option in v2.4: regex (microsoft clarity cookies)
                        col2: WWW_HOST,
                        col3: 'These cookies are set by microsoft clarity',
                        // path: '/',               // New option in v2.4
                        is_regex: true // New option in v2.4
                    }]
                }, {
                    title: 'ข้อมูลมากกว่านี้',
                    description: LOREM_IPSUM + ' <a class="cc-link" href="#">ติดต่อฉัน</a>.',
                }]
            }
        }
    }
});