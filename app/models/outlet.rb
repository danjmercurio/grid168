# == Schema Information
#
# Table name: outlets
#
#  id           :integer(4)      not null, primary key
#  name         :string(255)     not null
#  description  :string(255)
#  subs         :integer(4)      not null
#  dma_id       :integer(4)      not null
#  user_id      :integer(4)      not null
#  created_at   :datetime
#  updated_at   :datetime
#  outlet_type  :integer(4)      default(0), not null
#  first_name   :string(255)
#  last_name    :string(255)
#  phone_number :string(255)
#

class Outlet < ActiveRecord::Base
	belongs_to :user
	belongs_to :dma
  belongs_to :outlet_type
	with_options :dependent => :destroy do |o|
		o.has_many :offers
		o.has_many :sub_channels
	end


	attr_accessible :name, :first_name, :last_name, :phone_number, :description, :subs, :dma_id, :user_id, :outlet_type_id, :time_zone, :programming, :over_air, :total_homes

	validates :name, :first_name, :last_name, :phone_number, :dma_id, :subs, :outlet_type, :presence => true

	validates :name, uniqueness: { case_sensitive: false, message: "This outlet name already exists" }

	def count_offer
		self.offers.count
	end

	# check if contain sub channel, and sub channel has sub offer
	def contain_sub_offers?
		Outlet.joins('INNER JOIN sub_channels ON outlets.id = sub_channels.outlet_id INNER JOIN sub_channel_offers ON sub_channels.id = sub_channel_offers.sub_channel_id').where('outlets.id = ?', self.id).count > 0
	end

	def array_sub_offers
		SubChannelOffer.joins('INNER JOIN sub_channels ON sub_channels.id = sub_channel_offers.sub_channel_id INNER JOIN outlets ON outlets.id = sub_channels.outlet_id').where('outlets.id = ?', self.id).map(&:id)
	end

	# count offers by type: ex: 1 for broadcast, 2 for cable system, 3 for network
	def self.count_offers_by_type(type_number)
		Outlet.joins('INNER JOIN offers ON outlets.id = offers.outlet_id').where('outlets.outlet_type = ?', type_number).count
	end

	# count bids by type: ex: 1 for broadcast, 2 for cable system, 3 for network
	def self.count_bid_offers_by_type(type_number)
		Outlet.joins('INNER JOIN offers ON outlets.id = offers.outlet_id').where('outlets.outlet_type = ?',
			type_number).sum('offers.yearly_offer').to_f.round(2)
	end

	# Return array of amount offer by outlet type for highchart data
	def self.highchart_amount_offers
		# Outlet.joins('INNER JOIN offers ON outlets.id = offers.outlet_id')
		# 			.group('outlets.outlet_type').count.map{|x| x[1]} << SubChannelOffer.count
		offers_by_type = []
		for type_number in 1..3 do
			offers_by_type << Outlet.count_offers_by_type(type_number)
		end
		offers_by_type << SubChannelOffer.count
	end

	# Return array of  yearly offer by outlet type for highchart data
	def self.highchart_amount_bids
		# Outlet.joins('INNER JOIN offers ON outlets.id = offers.outlet_id')
		# 			.group('outlets.outlet_type').sum('offers.yearly_offer').map{|x| x[1].round(2)} << SubChannelOffer.sum(:yearly_offer).round(2)
		bid_offers_by_type = []
		for type_number in 1..3 do
			bid_offers_by_type << Outlet.count_bid_offers_by_type(type_number)
		end
		bid_offers_by_type << SubChannelOffer.sum(:yearly_offer).to_f.round(2)
	end

end
