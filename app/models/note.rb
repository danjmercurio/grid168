# == Schema Information
#
# Table name: notes
#
#  id         :integer(4)      not null, primary key
#  content    :text
#  offer_id   :integer(4)
#  created_at :datetime
#  updated_at :datetime
#

class Note < ActiveRecord::Base
	belongs_to :offer
	
	validates :content, :presence => true
	
	attr_accessible :content, :offer_id
end
