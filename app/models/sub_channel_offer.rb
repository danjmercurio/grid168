# == Schema Information
#
# Table name: sub_channel_offers
#
#  id                :integer(4)      not null, primary key
#  yearly_offer      :float           default(0.0), not null
#  monthly_offer     :float           default(0.0), not null
#  weekly_offer      :float           default(0.0), not null
#  hourly_rate       :float           default(0.0), not null
#  total_hours       :float           default(0.0), not null
#  dollar_amount     :float           default(0.0), not null
#  half_hour_clicked :text
#  sub_channel_id    :integer(4)
#  created_at        :datetime
#  updated_at        :datetime
#  user_id           :integer(4)      not null
#

class SubChannelOffer < ActiveRecord::Base
	belongs_to :sub_channel
	belongs_to :user
	has_and_belongs_to_many :programmers

	attr_accessible :yearly_offer, :monthly_offer, :weekly_offer, :hourly_rate, :total_hours, 
				:dollar_amount, :sub_channel_id, :programmer_ids, :user_id

	validates :dollar_amount, :presence => true,
								numericality: { greater_than: 0 }

	validates :total_hours, numericality: {
								greater_than: 0,
								message: "You must select half-hour and calculate."
								}

	validates :programmer_ids, :hourly_rate, :monthly_offer, :weekly_offer, :yearly_offer,
						:dollar_amount, :total_hours, :user_id, presence: true

	# list all programmers's name of this offer and parse to array
	def list_programmer_names
		self.programmers.select(:name).map{|x| x.name}
	end
end
