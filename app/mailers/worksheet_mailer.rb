class WorksheetMailer < ApplicationMailer
  def sendWorksheet(offer, toEmail, carbonCopy, subject, emailMessage, attachment_file)
    @offer = offer
    @outlet = @offer.outlet
    @emailMessage = emailMessage
    if attachment_file
      attachments[attachment_file.original_filename] = File.read(attachment_file.tempfile)
    end
    mail(to: toEmail, cc: carbonCopy, subject: subject, reply_to: 'grid168reply@acrossplatforms.com', template_path: 'offers',
         :template_name => '_email')
  end
end
