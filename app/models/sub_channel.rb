# == Schema Information
#
# Table name: sub_channels
#
#  id                  :integer(4)      not null, primary key
#  sub_channel_type_id :integer(4)
#  subs                :integer(4)
#  outlet_id           :integer(4)
#  created_at          :datetime
#  updated_at          :datetime
#  name                :string(255)
#

class SubChannel < ActiveRecord::Base
	belongs_to :outlet
	belongs_to :sub_channel_type
	has_many :sub_channel_offers, :dependent => :destroy

	attr_accessible :name, :subs, :outlet_id, :sub_channel_type_id

	validates :name, :subs, :sub_channel_type_id, presence: true

	def display_name_with_type
		self.name + " " + self.sub_channel_type.name
	end

end
