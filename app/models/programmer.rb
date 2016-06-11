# == Schema Information
#
# Table name: programmers
#
#  id          :integer(4)      not null, primary key
#  name        :string(255)
#  description :text
#  created_at  :datetime
#  updated_at  :datetime
#  user_id     :integer(4)
#  first_name  :string(255)
#  last_name   :string(255)
#  email       :string(255)
#  phone       :string(255)
#

class Programmer < ActiveRecord::Base
	belongs_to :user
	has_and_belongs_to_many :offers

	validates :name, presence: true

	attr_accessible :first_name, :last_name, :description, :name, :email, :phone, :website, :programmerType

	def won
		self.offers.where(:status => 'Closed Won').length
	end

	def lost
		self.offers.where(:status => 'Closed Lost').length
	end
end
