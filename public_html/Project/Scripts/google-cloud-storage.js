// /*
//     Create Function that takes the upload files sends to Google Cloud Storage
//     and returns the URL to the image
//     sends the url and rest of data to the database 
//     to be updated in the database
//     ||
//     \/
// */

// //requier Google Cloud Storage
// const GoogleCloudStorage = require('@google-cloud/storage');
// const exp = require('constants');
// //Set the project ID
// const GOOGLE_CLOUD_PROJECT_ID = 'astral-host-357215';
// //Set Path to the key file
// //Check if file exist before trying to use it
// const fs = require('fs');
// if (fs.existsSync('./google-cloud-key.json')) {  
//     const GOOGLE_CLOUD_KEYFILE = './google-cloud-key.json';
//     console.log('Using local key file');
// }else{
//     console.log("File not found");
// }

// const storage = new GoogleCloudStorage({
//     projectId: GOOGLE_CLOUD_PROJECT_ID,
//     keyFilename: GOOGLE_CLOUD_KEYFILE
// });


// const generateURL = () => {
//     /**
//      * Get public URL of a file
//      * @param {string} bucketName Name of the bucket
//      * @param {string} filename Name of the file
//      * @return {string}
//     */
//    exports.getPublicUrl = (bucketName, filename) => `https://storage.googleapis.com/${bucketName}/${filename}`;
// }

// const uploadFile = () => {
//     /**
//      * @param {string} localFilePath
//      * @param {string} bucketName
//      * @param {Object} [options] Optional parameters.
//      * @return {Promise<string>} - URL of the uploaded file
//     */
//     exports.copyFileToGCS = (localFilePath, bucketName, options) => {
//         options = options || {};
//         const bucket = storage.bucket(bucketName);
//         const fileName = path.basename(localFilePath);
//         const file = bucket.file(fileName);

//         return bucket.upload(localfilePath, options)
//         .then(() =>  file.makePublic())
//         .then(() => exports.getPublicUrl(bucketName, gcsName));
//     };
// }

// //From POST request send the Image to Google Cloud Storage
// // const uploadImage = (req, res) => {
// //     const bucketName = 'astral-host-357215';
// //     const file = req.files.file;
// //     const gcsName = `${Date.now()}-${file.name}`;
// //     const gcs = storage.bucket(bucketName);
// //     const filePath = file.path;
// //     const options = {
// //         destination: gcsName,
// //         metadata: {
// //             contentType: file.type
// //         }
// //     };
// //     gcs.upload(filePath, options, (err, file) => {
// //         if (err) {
// //             console.log(err);
// //             return res.status(500).send(err);
// //         }
// //         const url = generateURL(bucketName, gcsName);
// //         res.send(url);
// //         //log the url to the console
// //         console.log(url);
// //     });
// // }