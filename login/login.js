var _0x5e9c = ['Please enter Username', 'Code不能为空', '.reload-vify', 'click', 'children', 'prop', 'src', 'KF5SupportBoxAPI', 'ready', 'removeButton', 'preventDefault', 'open', 'search', 'indexOf', 'user', 'length', 'replace', 'user=', 'find', 'selectpicker', '#loginForm', '#username', 'val', 'formValidation', 'loginName', 'password', 'change', 'zh_CN', 'bootstrap', 'icon\x20wb-close', 'icon\x20wb-refresh'];
(function (_0x1a7d8a, _0x4a4318) {
    var _0x56295c = function (_0x523295) {
        while (--_0x523295) {
            _0x1a7d8a['push'](_0x1a7d8a['shift']());
        }
    }; _0x56295c(++_0x4a4318);
}(_0x5e9c, 0x1be));
var _0xc5e9 = function (_0x63d097, _0x206ea2) {
    _0x63d097 = _0x63d097 - 0x0; var _0x511c6 = _0x5e9c[_0x63d097]; return _0x511c6;
};
(function (_0x37b731, _0x423113, _0xf4c10c) {
    'use strict';
    var _0x408c86 = _0xf4c10c('#identity'),
        _0x1d0ecf = location[_0xc5e9('0x0')],
        _0xfc28b5 = _0x1d0ecf[_0xc5e9('0x1')](_0xc5e9('0x2')),
        _0x10b0d9 = _0x1d0ecf['substring'](_0xfc28b5, _0x1d0ecf[_0xc5e9('0x3')]);
    _0x10b0d9 = _0x10b0d9[_0xc5e9('0x4')](_0xc5e9('0x5'), '');
    function _0x69e615(_0x426d2d) {
        var _0x4e304d = _0x408c86[_0xc5e9('0x6')]
            ('option[value=\x22' + _0x426d2d + '\x22]')
        ['data']('password');
        if (_0xfc28b5 !== -0x1) {
            _0x408c86[_0xc5e9('0x7')]('val', _0x426d2d);
        }
        _0xf4c10c(_0xc5e9('0x8'))[_0xc5e9('0x6')](_0xc5e9('0x9'))[_0xc5e9('0xa')](_0x426d2d);
        _0xf4c10c('#loginForm')[_0xc5e9('0x6')]('#password')[_0xc5e9('0xa')](_0x4e304d);
        _0xf4c10c('#loginForm')[_0xc5e9('0xb')]('revalidateField', _0xc5e9('0xc'))['formValidation']('revalidateField', _0xc5e9('0xd'));
    }
    _0x408c86[_0xc5e9('0x7')]({
        'style': 'btn-select'
    });
    if (_0x10b0d9 !== '') {
        _0x69e615(_0x10b0d9);
    }
    _0x408c86['on'](_0xc5e9('0xe'),
        function () {
            _0x69e615(_0xf4c10c(this)[_0xc5e9('0xa')]());
        });
    _0xf4c10c('#loginForm')['formValidation']({
        'locale': _0xc5e9('0xf'),
        'framework': _0xc5e9('0x10'),
        'excluded': ':disabled',
        'autoFocus': !![],
        'icon': {
            'valid': 'icon\x20wb-check',
            'invalid': _0xc5e9('0x11'),
            'validating': _0xc5e9('0x12')
        },
        'fields': {
            'loginName': {
                'validators': {
                    'notEmpty': {
                        'message': _0xc5e9('0x13')
                    }
                }
            }, 'password': {
                'validators': {
                    'notEmpty': {
                        'message': 'Please Enter Password !'
                    },
                    'stringLength': {
                        'min': 4,
                        'max': 30,
                        //0x6,0x1e
                        'message': 'Password must between 4~30 character'
                    }
                }
            },
        }
    });
    _0xf4c10c(_0xc5e9('0x15'))['on'](_0xc5e9('0x16'),
        function () {
            var _0x24f523 = _0xf4c10c(this)[_0xc5e9('0x17')]('img'),
                _0x311d72 = _0x24f523[_0xc5e9('0x18')](_0xc5e9('0x19'));
            _0x24f523[_0xc5e9('0x18')](_0xc5e9('0x19'),
                _0x311d72 + '?tm=' + Math['random']());
        });
    _0x37b731[_0xc5e9('0x1a')][_0xc5e9('0x1b')](
        function () {
            _0x37b731[_0xc5e9('0x1a')][_0xc5e9('0x1c')]();
        });
    _0xf4c10c(_0x423113)['on'](_0xc5e9('0x16'), '.open-kf',
        function (_0x2dd906) {
            _0x2dd906[_0xc5e9('0x1d')]();
            _0x37b731[_0xc5e9('0x1a')][_0xc5e9('0x1e')]();
        });
}
    (window, document, jQuery));