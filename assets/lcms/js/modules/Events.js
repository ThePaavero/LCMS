LCMS.Modules.EventClass = function() {

    var self = this;

    this.listening = [];

    this.dispatchEvent = function(eventName, data) {
        for (var i = 0; i < this.listening.length; i++) {
            if(this.listening[i].eventName === eventName) {
                var callback = this.listening[i].callback;
                callback(data);
            }
        }
    };

    this.addEventListener = function(caller, eventName, callback) {
        this.listening.push({
            caller: caller,
            eventName: eventName,
            callback: callback,
        });
    };

    this.removeEventListener = function(caller, eventName) {
        // Get list of listeners
        var remove = [];
        for (var i = 0; i < this.listening.length; i++) {
            if(this.listening[i].caller === caller &&
                this.listening[i].eventName === eventName) {
                remove.push(i);
            }
        }

        // Remove them
        for (i = 0; i < remove.length; i++) {
            this.listening.splice(remove[i], 1);
        }
    };
};

LCMS.Modules.Events = new LCMS.Modules.EventClass();
