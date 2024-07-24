// commonProfileStatus.js

function checkProfileCompleteness(leadDetails) {
    var name = leadDetails.name || '';
    var email = leadDetails.email || '';
    var mobile = leadDetails.mobile || '';
    var altmobile = leadDetails.altmobile || '';
    var location = leadDetails.location || '';
    var pin = leadDetails.pin || '';
    var account = leadDetails.account || '';
    var ifsc = leadDetails.ifsc || '';
    var bankno = leadDetails.bankno || '';
    var branch = leadDetails.branch || '';
    var rerano = leadDetails.rerano || '';
    var gst = leadDetails.gst || '';

    // Check if all required fields are filled
    return (
        name !== '' &&
        email !== '' &&
        mobile !== '' &&
        altmobile !== '' &&
        location !== '' &&
        pin !== '' &&
        account !== '' &&
        ifsc !== '' &&
        bankno !== '' &&
        branch !== '' &&
        rerano !== '' &&
        gst !== ''
    );
}


