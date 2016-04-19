class WorksheetMailer < ApplicationMailer
  def sendWorksheet(offer, toEmail, carbonCopy, subject)
    @offer = offer


    # Handle error cases here. Ex. if toEmail is null

    result = mail(to: toEmail, cc: carbonCopy, subject: subject, template_path: 'offers',
                  :template_name => '_email').deliver
    result
  end
end
