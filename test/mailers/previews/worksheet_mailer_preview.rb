# Preview all emails at http://localhost:3000/rails/mailers/worksheet_mailer
class WorksheetMailerPreview < ActionMailer::Preview
  def sendWorksheet
    @offer = Offer.where(:id => 4).first
  end
end
