# == Schema Information
#
# Table name: offers
#
#  id                :integer(4)      not null, primary key
#  outlet_id         :integer(4)
#  yearly_offer      :float           default(0.0), not null
#  monthly_offer     :float           default(0.0), not null
#  weekly_offer      :float           default(0.0), not null
#  hourly_rate       :float           default(0.0), not null
#  total_hours       :float           default(0.0), not null
#  created_at        :datetime
#  updated_at        :datetime
#  dollar_amount     :float           default(0.0), not null
#  half_hour_clicked :text
#  user_id           :integer(4)
#

class Offer < ActiveRecord::Base
	after_initialize :set_defaults, :unless => :persisted?

	belongs_to :outlet
	has_and_belongs_to_many :programmers
	belongs_to :user
	has_many :notes, :dependent => :destroy

  	attr_accessible :programmer_ids, :yearly_offer, :monthly_offer, :outlet_id, :weekly_hours,
									:monthly_hours, :yearly_hours, :weekly_offer, :hourly_rate, :total_hours,
									:dollar_amount, :user_id, :time_cells, :available_date, :grNotes, :dpNotes,
									:mvpdSubscriberRate, :mvpdOtaSubRate, :halfHourRate, :morningAudience,
									:morningRate, :morningHours, :morningWeeklyRate, :daytimeAudience, :daytimeRate,
									:daytimeHours, :daytimeWeeklyRate, :eveningNewsAudience, :eveningNewsRate,
									:eveningNewsHours, :eveningNewsWeeklyRate, :localPrimeTimeAudience, :localPrimeTimeRate,
									:localPrimeTimeHours, :localPrimeTimeWeeklyRate, :nationalPrimeTimeAudience,
									:nationalPrimeTimeRate, :nationalPrimeTimeHours, :nationalPrimeTimeWeeklyRate,
									:lateNewsAudience, :lateNewsRate, :lateNewsHours, :lateNewsWeeklyRate, :lateNightAudience,
									:lateNightRate, :lateNightHours, :lateNightWeeklyRate, :overnightsAudience, :overnightsRate,
									:overnightsHours, :overnightsWeeklyRate, :runningAudienceTotal, :runningHoursTotal, :runningWeeklyRateTotal,
									:disclaimer,
									:internalNotes,
									:status,
									:programming

  	validates :dollar_amount, :presence => true,
								numericality: { greater_than: 0 }

	validates :total_hours, numericality: {
      greater_than: 0,
      message: 'You must select half-hour and calculate.'
								}

	validates :programmer_ids, :hourly_rate, :monthly_offer, :weekly_offer, :yearly_offer,
						:dollar_amount, :total_hours, :user_id, presence: true

	# list all programmers's name of this offer and parse to array
	def list_programmer_names
		self.programmers.select(:name).map{|x| x.name}
	end

	private

	def set_defaults
		self.disclaimer ||= "This worksheet is neither a bid nor an offer made on behalf of a programming supplier or on behalf of any other third-party.
    Across Platforms, Inc. is not acting as an agent for any third-party. This worksheet is merely an example of the terms that might be available, based upon the information mentioned in the worksheet, and Across Platforms' considerable expertise in the television industry.
    It is not a representation that these terms are available. With your permission, Across Platforms may submit this worksheet to various programming suppliers whose identities will be determined according to Across Platforms' sole and exclusive discretion.
    In the event there are any further negotiations between you and any programming supplier contacted by Across Platforms, then Across Platforms will be acting as an agent for the programming supplier, and will be paid a commission by the programming supplier if the negotiations result in a binding contract.
    "

    self.grNotes ||= 'Annual Rate for MVPD and OTA - Per OTA home and MVPD subscriber annual cost\nMVPD Subscriber Rate - Per subscriber annual cost (not including OTA)
    OTA Home Rate - Per OTA home annual cost (not including MVPD)'

    self.dpNotes ||= 'Estimated percentage of weekly viewing is a composite of publicly reported viewing trends across all television channels, and networks, based on live time of day viewing.'
    self.status ||= 'Current'

  end
end
