import express from "express";
import multer from "multer";
import { handleFileUpload } from "./file-upload-util.js";

const app = express();
const multerParse = multer({
  dest: "uploads/",
});

app.get("/", (req, res) => {
  res.json({
    message: "Hello I am working",
  });
});

app.post(
  "/upload",
  multerParse.fields([
    {
      name: "attachment",
    },
  ]),
  async (req, res) => {
    const attachment = req.files?.attachment[0];

    if (!attachment) {
      res.status(400).json({ message: "No file uploaded" });
    }

 
    const uploadResponse = await handleFileUpload(attachment);

    if (uploadResponse) {
      res.status(201).json({
        message: "file uploaded",
        url: uploadResponse,
      });
    } else {
      res.status(500).json({
        message: "file upload failed",
      });
    }
  }
);

app.listen(3000, () => {
  console.log("server running on port 3000");
});
