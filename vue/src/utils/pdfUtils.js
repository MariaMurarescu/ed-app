// pdfUtils.js

import { PDFDocument, rgb, StandardFonts } from 'pdf-lib';

// Function to create a PDF for a single lesson
export async function createPDF(lesson) {
  // Create a new PDF document
  const pdfDoc = await PDFDocument.create();
  
  // Add a new page to the document
  const page = pdfDoc.addPage([600, 400]); // Adjust the page size as needed

  // Add content to the page for the selected lesson
  page.drawText('Lesson Title: ' + lesson.title, {
    x: 50,
    y: 350,
    size: 24,
    color: rgb(0, 0, 0),
  });

  // Check if description is available
  const descriptionText = lesson.description ? lesson.description : 'No description available';
  const helveticaFont = await pdfDoc.embedFont(StandardFonts.Helvetica);
  
  const maxWidth = 500; // Adjust the maximum width of the text
  const lineHeight = 20; // Adjust the line height as needed

  let lines = [];
  let line = '';
  for (const word of descriptionText.split(' ')) {
    const width = helveticaFont.widthOfTextAtSize(line + ' ' + word, 12);
    if (width < maxWidth) {
      line += (line ? ' ' : '') + word;
    } else {
      lines.push(line);
      line = word;
    }
  }
  if (line.trim().length > 0) {
    lines.push(line);
  }

  let y = 300; // Adjust the initial y position
  for (const line of lines) {
    page.drawText(line, {
      x: 50,
      y,
      size: 12,
      font: helveticaFont,
      color: rgb(0, 0, 0),
    });
    y -= lineHeight;
  }

  // Add more content as needed

  // Serialize the PDF document to bytes
  const pdfBytes = await pdfDoc.save();

  // Create a blob from the bytes
  const blob = new Blob([pdfBytes], { type: 'application/pdf' });

  // Download the PDF file
  const url = window.URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = 'lesson.pdf'; // Adjust the filename as needed
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
  window.URL.revokeObjectURL(url);
}
