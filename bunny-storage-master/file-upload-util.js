import axios from "axios";
import fs from "fs";

export const handleFileUpload = async (file) => {
  const fileStream = fs.createReadStream(file.path);
  const uniqueFilename = `${Date.now()}-${file.filename}-${file.originalname}`;

  let yourStorageZone;
  const response = await axios.put(
    //url
    //stream
    //headers
    `https://storage.bunnycdn.com/my-storage-node/${uniqueFilename}`,
    fileStream,
    {
      headers: {
        AccessKey: "11035661-6fff-4b87-8b368c53b622-eba3-4026",
      },
    }
  );

  if (response.data) {
    return `https://.b-cdn.net/${uniqueFilename}`;
  } else {
    return false;
  }
};
