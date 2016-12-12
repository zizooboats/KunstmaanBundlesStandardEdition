(function iifeDevice (win, docEl, radio) {

    var SMALL = 600;
    var LARGE = 1025;
    var XLARGE = 1500;
    var XXLARGE = 1750;
    var LONGER_SIDE_THRESHOLD = 720;
    var device;

    function bindEvents() {
        if ('addEventListener' in win) {
            win.addEventListener('resize', handleResize, false);
        } else {
            win.attachEvent('resize', handleResize);
        }
    }

    function handleResize(e) {
        var currentDevice = determineDevice();

        if (currentDevice !== device) {
            setDevice(currentDevice);
        }
    }

    function getLongerSide(w, h) {
        return w > h ? w : h;
    }

    function determineDevice() {
        var width = docEl.clientWidth;
        var height = docEl.clientHeight;
        var longerSide = getLongerSide(width, height);
        var currentDevice;

        if (width >= XXLARGE) {
            currentDevice = 'xxl';
        } else if (width >= XLARGE) {
            currentDevice = 'xl';
        } else if (width >= LARGE) {
            currentDevice = 'l';
        } else if (width >= SMALL && longerSide >= LONGER_SIDE_THRESHOLD) {
            currentDevice = 'm';
        } else if (width < SMALL || (width >= SMALL && longerSide < LONGER_SIDE_THRESHOLD)) {
            currentDevice = 's';
        }

        return currentDevice;
    }

    function setDevice(deviceType) {
        device = deviceType;

        if (/device--[smxl]{1,3}/.test(docEl.className)) {
            docEl.className = docEl.className.replace(/device--[smxl]{1,3}/, 'device--' + device);
        } else {
            docEl.className += (' device--' + device);
        }

        console.log('-- setting device:', device);
        radio('deviceChange').broadcast({ type: device });
    }

    setDevice(determineDevice());
    bindEvents();

    window.DeviceInspector = {
        getDevice: function() {
            return device ? device : determineDevice()
        }
    };

}(window, document.documentElement, radio));
