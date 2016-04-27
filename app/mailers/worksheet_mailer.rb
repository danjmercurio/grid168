class WorksheetMailer < ApplicationMailer
  def sendWorksheet(offer, toEmail, carbonCopy, subject, emailMessage)
    @offer = offer
    @emailMessage = emailMessage
    mail(to: toEmail, cc: carbonCopy, subject: subject, reply_to: 'mkokernak@acrossplatforms.com', template_path: 'offers',
         :template_name => '_email')
  end
end
