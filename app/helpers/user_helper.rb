module UserHelper
	def display_email_offers(user)
		user.email + " " + pluralize(user.count_offers, "offer")
	end #end display_email_offers method
end
